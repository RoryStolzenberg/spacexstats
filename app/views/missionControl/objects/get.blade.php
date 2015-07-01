@extends('templates.main')

@section('title', $object->title)
@section('bodyClass', 'object')

@section('scripts')
@stop

@section('content')
    <div class="content-wrapper">
        <h1>{{ $object->title }}</h1>
        <main>
        </main>
    </div>
@stop