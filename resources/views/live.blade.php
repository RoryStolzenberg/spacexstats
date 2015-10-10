@extends('templates.main')
@section('title', 'Live')

@section('content')
    <body class="live">

    @include('templates.flashMessage')
    <!-- Custom Header -->


    <div class="content-wrapper">
        <h1>SpaceX Stats Live</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-1">Stuff</li>
                </ul>
            </nav>
            <section class="highlights">
            </section>
            <section>
            </section>
        </main>
    </div>
    </body>
@stop