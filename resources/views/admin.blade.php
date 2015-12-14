@extends('templates.main')
@section('title', 'Admin')

@section('content')
<body class="admin">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Admin</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-1">Stuff</li>
                </ul>
            </nav>
            <section>
                <ul>
                    <li><a href="/missions/create">Create A Mission</a></li>
                    <li>Review Queue</li>
                    <li>Meta Stats</li>
                </ul>
            </section>
        </main>
    </div>
</body>
@stop