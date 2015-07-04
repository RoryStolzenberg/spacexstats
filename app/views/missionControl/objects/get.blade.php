@extends('templates.main')

@section('title', $object->title)
@section('bodyClass', 'object')

@section('scripts')
@stop

@section('content')
    <div class="content-wrapper">
        <h1>{{ $object->title }}</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="grid-2">{{ $object->present()->type() }}</li>
                    <li class="grid-2">Comments</li>
                </ul>
            </nav>

            <section class="details">
                <div class="grid-8">
                    <img src="{{ $object->filename }}" />
                </div>
                <div class="grid-4">
                    <p>Uploaded by {{ link_to_route('users.get', $object->user->username, array('username' => $object->user->username)) }}<br/>
                        On {{ $object->present()->created_at() }}</p>
                    <ul>
                        <li>{{ $object->present()->subtype() }}</li>
                    </ul>
                </div>
            </section>

            <section class="comments">

            </section>
        </main>
    </div>
@stop