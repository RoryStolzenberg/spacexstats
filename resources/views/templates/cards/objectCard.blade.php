<div class="card object-card">
    <div class="thumb-holder">
        <img class="thumb" src="{{ $object->media_thumb_small }}" title="{{ $object->title }}"/>
    </div>

    <div class="object-overview">
        <p class="title"><a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a></p>
        <p class="type creator date">{{ $object->present()->type() }} submitted by <a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</a> on {{ $object->created_at->toFormattedDateString() }}</p>

        <p class="comments">
        @if ($object->comments->count() == 1)
            1 comment
        @else
            <span>{{ $object->comments->count() }} comments</span>
        @endif
        </p>

        <div class="tags">
            @foreach ($object->tags as $tag)
                <div class="tag">{{ $tag->name }}</div>
            @endforeach
        </div>
    </div>

</div>