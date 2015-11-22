<div class="card object-card">
    <div class="thumb-holder">
        <img class="thumb" src="{{ $object->media_thumb_small }}" title="{{ $object->title }}"/>
    </div>

    <div class="object-overview">
        <p class="title"><a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a></p>
        <p>A {{ strtolower($object->present()->type()) }} submitted by <a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</p>
        @if ($object->comments->count() == 1)
            <p>1 comment</p>
        @else
            <p><span>{{ $object->comments->count() }} comments</span></p>
        @endif
        <div>
            @foreach ($object->tags as $tag)
                <div class="tag">{{ $tag->name }}</div>
            @endforeach
        </div>
    </div>

</div>