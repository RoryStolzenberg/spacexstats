@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about">

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background">
        <h1>Mission Control - The best blah blah</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Text & Email Notifications</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Gigabytes Now, Terabytes Soon.</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Unparalleled Analytics</h1>
    </div>
</body>
@stop

