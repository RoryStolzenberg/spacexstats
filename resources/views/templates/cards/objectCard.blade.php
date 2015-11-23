<div class="card object-card">
    <div class="thumb-holder">
        <img class="thumb" src="{{ $object->media_thumb_small }}" title="{{ $object->title }}"/>
    </div>

    <div class="object-overview">
        <p class="title">
            <a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a>
        </p>
        <p class="type creator date">
            {{ $object->present()->type() }} submitted
            @if (!$object->anonymous)
                by <a href="/users/{{ $object->user->username }}">{{ $object->user->username }}</a>
            @endif
            on {{ $object->created_at->toFormattedDateString() }}</p>

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

        @if ($object->status == \SpaceXStats\Library\Enums\ObjectPublicationStatus::PublishedStatus)
            <i class="publication-status fa fa-check"></i>
        @elseif ($object->status == \SpaceXStats\Library\Enums\ObjectPublicationStatus::QueuedStatus)
            <i class="publication-status fa fa-repeat"></i>
        @else
            <i class="publication-status fa fa-warning"></i>
        @endif
    </div>

</div>