<div class="card object-card {{$bias}}">
    <div class="thumb-holder">
        <img class="thumb" src="{{ $object->media_thumb_small }}" title="{{ $object->title }}"/>
    </div>


    <div class="object-overview">
        <p><a href="/missioncontrol/objects/{{ $object->object_id }}">{{ $object->title }}</a></p>
    </div>

</div>