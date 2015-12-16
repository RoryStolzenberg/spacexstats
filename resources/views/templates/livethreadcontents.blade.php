# Welcome to the {{ \Redis::hget('live:reddit', 'title') }}!

{{ \Redis::hget('live:description', 'raw') }}

### Watching the launch live

To watch the launch live, pick your preferred streaming provider from the table below:

| [SpaceX Stats Live (Webcast + Live Updates)](https://spacexstats.com/live) |
| --- |
| [SpaceX Livestream (Webcast)](https://livestream.com/spacex) |
@if (isset(json_decode(\Redis::hget('live:streams', 'spacex'))->youtubeVideoId))
| [SpaceX YouTube](https://youtube.com/watch?v={{ json_decode(\Redis::hget('live:streams', 'spacex'))->youtubeVideoId }}
@endif

### Official Live Updates

| Time | Update |
|--- | --- |
@if (isset($updates))
@for($i = 0; $i <= 50; $i++)
@if (array_key_exists($i, $updates))
| {{ $updates[$i]->timestamp }} | {{ $updates[$i]->update }} |
@endif
@endfor
@endif

@foreach(json_decode(\Redis::get('live:sections'), true) as $section)
### {{ $section['title'] }}

{{ $section['content'] }}
@endforeach

### Useful Resources, Data, ?, & FAQ
@foreach(json_decode(\Redis::get('live:resources'), true) as $resource)
@if ($resource['courtesy'] != null)
* [{{ $resource['title'] }}]({{ $resource['url'] }}), {{ $resource['courtesy'] }}
@else
* [{{ $resource['title'] }}]({{ $resource['url'] }})
@endif
@endforeach

### Participate in the discussion!

* First of all, Launch Threads are a party threads! We understand everyone is excited, so we relax the rules in these venues. The most important thing is that everyone enjoy themselves :D
* All other threads are fair game. We will remove low effort comments elsewhere!
* Real-time chat on our official Internet Relay Chat (IRC) [#spacex at irc.esper.net](https://kiwiirc.com/client/irc.esper.net/?nick=SpaceX_guest%7C?#SpaceX)
* Please post small launch updates, discussions, and questions here, rather than as a separate post. Thanks!

### Prevous /r/SpaceX Live Events

Check out previous /r/SpaceX Live events in the [Launch History page](http://www.reddit.com/r/spacex/wiki/launches) on our community Wiki.