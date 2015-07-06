@extends('templates.main')

@section('title', $mission->name)
@section('bodyClass', 'past-mission')

@section('scripts')
@stop

@section('content')
<div class="content-wrapper">
	<h1>{{ $mission->name }}</h1>
	<main>
		<nav class="sticky-bar">
			<ul class="container">
				<li class="grid-1">Article</li>
				<li class="grid-1">Details</li>
				<li class="grid-1">Timeline</li>
				<li class="grid-1">Images</li>
				<li class="grid-1">Videos</li>
				<li class="grid-1">Articles</li>
				<li class="grid-3 actions">
					<a href="/missions/{{ $mission->slug }}/edit"><i class="fa fa-pencil"></i></a>
					<i class="fa fa-twitter"></i>
					<i class="fa fa-rss"></i>
				</li>
				<li class="grid-1">Status</li>
			</ul>
		</nav>
		<section class="highlights">
            @if(isset($pastMission))
                <div class="past-mission-link">
                    {{ link_to_route('missions.get', $pastMission->name, $pastMission->slug) }}
                    <span>Previous Mission</span>
                </div>
            @endif
            @if(isset($futureMission))
                <div class="future-mission-link">
                    {{ link_to_route('missions.get', $futureMission->name, $futureMission->slug) }}
                    <span>Next Mission</span>
                </div>
            @endif
		</section>


		{{ $mission->present()->article() }}
		<p>{{ $mission->summary }}</p>
		<h2>Details</h2>
            @include('templates.missionCard', ['size' => 'large', 'mission' => $mission])
			<div class="grid-8">
				<h3>Flight Details</h3>
                <h3>Dragon</h3>
                <h3>Satellites</h3>
                <h3>Upper Stage</h3>
			</div>
			<div class="grid-4">
				<h3>Library</h3>
			</div>			
		<h2>Timeline</h2>
        <h3>Prelaunch</h3>
        <h3>Launch</h3>
        <h3>Postlaunch</h3>
		<h2>Images</h2>
		<h2>Videos</h2>
        <h2>Articles</h2>
        <section class="articles">
        </section>
	</main>
</div>
@stop