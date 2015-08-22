@extends('templates.main')
@section('title', 'Admin')

@section('content')
<body class="admin">

    <div id="flash-message-container">
        @if (Session::has('flashMessage'))
            <p class="flash-message {{ Session::get('flashMessage.type') }}">{{ Session::get('flashMessage.contents') }}</p>
        @endif
    </div>

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Admin</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="grid-1">Stuff</li>
                </ul>
            </nav>
            <section class="highlights">
            </section>
            <section>
                <ul>
                    <li>{{ link_to_route('missions.create', "Create A Mission") }}</li>
                    <li>Review Queue</li>
                    <li>Meta Stats</li>
                </ul>
            </section>
        </main>
    </div>
</body>
@stop