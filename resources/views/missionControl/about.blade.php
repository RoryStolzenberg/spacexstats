@extends('templates.main')
@section('title', 'About Mission Control')

@section('content')
<body class="missioncontrol-about">

    @include('templates.flashMessage')
    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background">
        <h1>Mission Control</h1>
        <main>
            <a href="/missioncontrol/buy">Buy Today!</a>
        </main>
    </div>
</body>
@stop

