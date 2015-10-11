@extends('templates.main')
@section('title', $user->username . '\'s Favorites')

@section('content')
    <body class="profile-favorites">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}'s Favorites</h1>
        <main>
        </main>
    </div>
    </body>
@stop
