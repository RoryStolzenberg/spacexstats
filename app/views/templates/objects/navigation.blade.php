<nav class="sticky-bar">
    <ul class="container">
        <li class="grid-2">{{ $object->present()->type() }}</li>
        <li class="grid-2">Summary</li>
        <li class="grid-2">Comments</li>
        @if (Auth::isSubscriber())
            <li class="grid-2">
                <a class="link" href="/missioncontrol/objects/{{ $object->object_id }}/edit">
                    <i class="fa fa-pencil"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>