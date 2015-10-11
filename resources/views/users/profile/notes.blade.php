@extends('templates.main')
@section('title', $user->username . '\'s Notes')

@section('content')
    <body class="profile-notes">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}'s Notes</h1>
        <main>
        </main>
    </div>
    </body>
@stop
