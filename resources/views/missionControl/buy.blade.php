@extends('templates.main')
@section('title', 'Get Mission Control')

@section('content')
<body class="missioncontrol-buy">


    @include('templates.header')

    <div class="content-wrapper single-page background">
        <h1>Get Mission Control</h1>
        <main>
            {{ Form::open(array('route' => 'missionControl.buy')) }}
            {{ Form::submit('Buy Now') }}
            {{ Form::close() }}
        </main>
    </div>
</body>
@stop

