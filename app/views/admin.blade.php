@extends('templates.main')

@section('title', 'Admin')
@section('bodyClass', 'admin')

@section('scripts')
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Admin</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="grid-1">Stuff</li>
                </ul>
            </nav>
            <section class="highlights">
            </section>
            <section>
                <ul>
                    <li>{{ link_to_route('missions.create', "Create A Mission") }}</li>
                    <li>Review Queue</li>
                    <li>Meta Stats</li>
                </ul>
            </section>
        </main>
    </div>
@stop