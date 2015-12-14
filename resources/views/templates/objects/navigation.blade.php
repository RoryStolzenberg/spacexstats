<nav class="in-page sticky-bar">
    <ul class="container">
        <li class="gr-2"><a href="#details">{{ $object->type }}</a></li>
        <li class="gr-2"><a href="#summary">Summary</a></li>
        <li class="gr-2"><a href="#comments">Comments</a></li>
        @if (Auth::isAdmin())
            <li class="gr-2">
                <a class="link" href="/missioncontrol/objects/{{ $object->object_id }}/edit"><i class="fa fa-pencil"></i></a>
            </li>
        @endif
    </ul>
</nav>