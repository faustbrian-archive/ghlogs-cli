<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Spatie\Regex\Regex;
use Jenssegers\Blade\Blade;

class InspiringCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'run {--user=} {--repo=} {--base=} {--head=} {--token=}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate a changelog for the given base...head';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->option("user");
        $repo = $this->option("repo");

        $url = "https://api.github.com/repos/{$user}/{$repo}/compare/{$this->option("base")}...{$this->option("head")}";

        $response = Http::withToken($this->option("token"))->get($url)->json();

        $commits = collect($response['commits'])
            ->transform(function ($item) {
                $message = strtok($item['commit']['message'], "\n");
                $message = $this->trimCommitMessage($message);
                $message = preg_replace('/#(\d+)/', '[${0}]', $message);

                preg_match('/#(\d+)/', $item['commit']['message'], $matches);

                return [
                    'type' => $this->getCommitType($item['commit']['message']),
                    'author' => $item['author']['login'],
                    'message' => $message,
                    'sha' => $item['sha'],
                    'number' => isset($matches[1]) ? $matches[1] : null,
                ];
            })
            ->reject(fn ($item) => empty($item['type']))
            ->groupBy('type')
            ->sort();

        $contributors = $commits->flatten(1)->pluck('author')->unique()->sort();

        $blade = new Blade('views', 'cache');
        $contents = $blade->make('changelog', compact('user', 'repo', 'commits', 'contributors'))->render();

        $this->info($contents);
    }

    private function getCommitType(string $message)
    {
        $types = [
            'chore' => 'Changed',
            'feat' => 'Added',
            'fix' => 'Fixed',
            'perf' => 'Changed',
            'polish' => 'Changed',
            'refactor' => 'Changed',
        ];

        foreach ($types as $label => $group) {
            if (Str::contains($message, 'removed')) {
                return 'Removed';
            }

            if (Str::startsWith($message, $label)) {
                return $group;
            }
        }
    }

    private function trimCommitMessage(string $message)
    {
        $pattern = '/(feat|fix|polish|docs|style|refactor|perf|test|workflow|ci|chore|types|release)(\(.+\))?:/';

        return trim(Regex::replace($pattern, '', $message)->result());
    }
}
