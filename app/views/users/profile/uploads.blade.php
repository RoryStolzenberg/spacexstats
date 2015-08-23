<?php
@extends('templates.main')
@section('title', $user->username . '\'s Uploads')

@section('content')
<body class="profile-uploads">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }} Uploads</h1>
        <main>
        </main>
    </div>
</body>
@stop
