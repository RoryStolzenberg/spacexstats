@extends('templates.main')
@section('title', $user->username . '\'s Comments')

@section('content')
    <body class="profile-comments">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}'s Comments</h1>
        <main>
        </main>
    </div>
    </body>
@stop
