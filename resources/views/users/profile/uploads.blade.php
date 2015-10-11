@extends('templates.main')
@section('title', $user->username . '\'s Uploads')

@section('content')
<body class="profile-uploads">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}'s Uploads</h1>
        <main>
        </main>
    </div>
</body>
@stop
