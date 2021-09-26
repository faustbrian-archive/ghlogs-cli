@foreach($commits as $group => $items)
### {{ $group }}

@foreach($items as $item)
- {{ $item['message'] }} ({{ substr($item['sha'], 0, 8) }}, {{ '@'.$item['author'] }})
@endforeach

@endforeach
@if($repo === 'desktop-wallet')
### Hashes

| File | SHA256 |
| --- | --- |
| linux-amd64.deb | - |
| linux-x64.tar.gz | - |
| linux-x86_64.AppImage | - |
| mac.dmg | - |
| mac.zip | - |
| win.exe | - |

@endif
Thanks to @foreach($contributors as $contributor){{ '@'.$contributor }} @endforeach


@foreach($commits as $group => $items)
@foreach($items as $item)
@if($item['number'])
[#{{ $item['number'] }}]: https://github.com/{{ $user }}/{{ $repo }}/pull/{{ $item['number'] }}
@endif
@endforeach
@endforeach
