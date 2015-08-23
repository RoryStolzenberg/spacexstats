@extends('templates.main')
@section('title', 'Past Launches')

@section('content')
<body class="past-launches">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Past Launches</h1>
        <main>
            <p>Browse all past launches here</p>
            <h2>Previous Launch</h2>
            <p>Detailed previous launch, reddit discussion thread, article, etc etc</p>
            <p>Have a "ribbon/badge beneath upcoming/previous launch count</p>
            <h2>Past Launches</h2>
            <p>Every other launch</p>
        </main>
    </div>
</body>
@stop