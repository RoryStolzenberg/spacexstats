<nav class="sticky-bar">
    <ul class="container">
        <li class="gr-2">{{ $object->present()->type() }}</li>
        <li class="gr-2">Summary</li>
        <li class="gr-2">Comments</li>
        @if (Auth::isSubscriber())
            <li class="gr-2">
                <a class="link" href="/missioncontrol/objects/{{ $object->object_id }}/edit">
                    <i class="fa fa-pencil"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>