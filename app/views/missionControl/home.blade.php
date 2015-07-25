@extends('templates.main')

@section('title', 'Mission Control')
@section('bodyClass', 'missioncontrol')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper">
	<h1>Mission Control</h1>
	<main>
        <form method="GET" action="/missioncontrol/search">
            <input type="search" placeholder="Search..." />
            <input type="submit" value="Search" />
        </form>
	</main>
</div>
@stop

