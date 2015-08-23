@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol">
    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Mission Control</h1>
        <main>
            <form method="GET" action="/missioncontrol/search">
                <input type="search" placeholder="Search..." />
                <input type="submit" value="Search" />
            </form>
        </main>
    </div>
</body>
@stop

