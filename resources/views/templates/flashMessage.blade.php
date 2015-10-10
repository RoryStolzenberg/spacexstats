<div id="flash-message-container">
    @if (Session::has('flashMessage'))
        <p class="flash-message {{ Session::get('flashMessage.type') }}">{{ Session::get('flashMessage.contents') }}</p>
    @endif
</div>