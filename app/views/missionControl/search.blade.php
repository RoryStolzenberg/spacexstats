@extends('templates.main')

@section('title', 'Search results for')
@section('bodyClass', 'search')

@section('scripts')
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Search results for</h1>
        <main>
            <form method="GET" action="/missioncontrol/search">
                <input type="search" placeholder="Search..." />
                <input type="submit" value="Search" />
            </form>
        </main>
    </div>
@stop

