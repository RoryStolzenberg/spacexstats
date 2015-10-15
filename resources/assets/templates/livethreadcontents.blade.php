# Welcome to the {{ \Redis::get('live:title') }}!

{{ \Redis::get('live:description') }}

### Watching the launch live

Populate the launch live area based on whether the NASA stream/SpaceX stream is running or not.

### Official Live Updates

| Time | Update |
|--- | --- |
@foreach(\Redis::lrange('live:messages', 0, -1)  as $message)
| {{ $message['relativeTime'] }} | {{ $message['content'] }} |
@endforeach

@foreach(\Redis::lrange('live:sections', 0, -1)  as $section)
### {{ $section['title'] }}

{{ $section['content'] }}

@endforeach

### Community Content

some content here

@foreach(\Redis::lrange('live:resources', 0, -1)  as $resource)
    @if ($resource['courtesy'] != null)
* [{{ $resource['title'] }}]({{ $resource['url'] }}), courtesy {{ $resource['courtesy'] }}
    @elseif
* [{{ $resource['title'] }}]({{ $resource['url'] }})
    @endif
@endforeach

### Prevous /r/SpaceX Live Events

Check out previous /r/SpaceX Live events in the [Launch History page](http://www.reddit.com/r/spacex/wiki/launches) on our community Wiki.

### Parctipate in the discussion!

* First of all, Launch Threads are a party threads! We understand everyone is excited, so we relax the rules in these venues. The most important thing is that everyone enjoy themselves :D
* Real-time chat on our official Internet Relay Chat (IRC) [#spacex at irc.esper.net](https://kiwiirc.com/client/irc.esper.net/?nick=SpaceX_guest%7C?#SpaceX)
* Please post small launch updates, discussions, and questions here, rather than as a separate post. Thanks!