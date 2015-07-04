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
                    <li class="grid-2">Edit</li>
                </ul>
            </nav>

            <section class="details">
                <div class="grid-8">
                    <img src="{{ $object->filename }}" />
                </div>
                <aside class="grid-4">
                    <div class="actions container">
                        <span class="grid-4">

                        </span>
                        <span class="grid-4">

                        </span>
                        <span class="grid-4">

                        </span>
                    </div>
                    <p>Uploaded by {{ link_to_route('users.get', $object->user->username, array('username' => $object->user->username)) }}<br/>
                        On {{ $object->present()->created_at() }}</p>
                    <ul>
                        <li>{{ $object->present()->subtype() }}</li>
                    </ul>
                </aside>
            </section>

            <h2>Summary</h2>
            <section class="notes">
                <textarea>{{ $userNote }}</textarea>
                <button>Save Note</button>
            </section>

            <section class="comments">

            </section>
        </main>
    </div>
@stop