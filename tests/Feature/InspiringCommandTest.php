<?php

test('log command', function () {
    $this->artisan('log')
         ->expectsOutput('Simplicity is the ultimate sophistication.')
         ->assertExitCode(0);
});
