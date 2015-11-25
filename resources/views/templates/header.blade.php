<div id="flash-message-container">
    @if (Session::has('flashMessage'))
        <p class="flash-message success">{{ Session::get('flashMessage') }}</p>
    @endif
</div>

<div class="header-wrapper {{ $class or null }}" style="background-image:url({{ $backgroundImage or null }})">
	<header>
			<i class="fa fa-navicon toggleMobileNavigation gridle-show-small"></i>
			<span id="logo"><a href="/">SpaceX Stats</a></span>
			<nav>
				<ul>
                    <li class="gr-1on8 gr-small-12">
                        <a href="/live">Live</a>
                    </li>
					<li class="gr-1on8 gr-small-12">
                        <a href="/missions/past">Past Missions</a>
						<ul class="nav-second-tier wide">
							@foreach ($nearbyMissions['past'] as $pastMission)
							<li><a href="/missions/{{ $pastMission->slug }}">{{ $pastMission->name }}</a></li>
							@endforeach
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12">
                        <a href="/missions/future">Future Missions</a>
						<ul class="nav-second-tier wide">
							@foreach ($nearbyMissions['future'] as $futureMission)
							<li><a href="/missions/{{ $futureMission->slug }}">{{ $futureMission->name }}</a></li>
							@endforeach
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12">
						More...
						<ul class="nav-second-tier wide">
                            <li><a href="/locations">Locations</a></li>
							<li><a href="/newssummaries">News Summaries</a></li>
							<li><a href="/faq">Frequently Asked Questions</a></li>
							<li><a href="/rss">RSS Updates</a></li>
                            <li><a href="/community">Community</a></li>
							<li><a href="/about">About</a></li>
							<li><a href="/about/contact">Contact & Tips</a></li>
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12 push-3">
                        <a href="/missioncontrol">Mission Control</a>
						<ul class="nav-second-tier">
							@if (Auth::isSubscriber())
								<li><a href="/missioncontrol/create">Upload</a></li>
                                <li><a href="/missioncontrol/collections">Collections</a></li>
								<li><a href="/missioncontrol/leaderboards">Leaderboards</a></li>
							@else
							    <li><a href="/missioncontrol">Buy</a></li>
							@endif
							<li><a href="/about/docs#missioncontrol">Docs</a></li>
                            @if (Auth::isAdmin())
                                <li><a href="/missioncontrol/review">Review</a></li>
                            @endif
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12 push-3">
						@if (Auth::check())
                            <a href="/users/{{ Auth::user()->username }}">{{ Auth::user()->username }}</a>
							<ul class="nav-second-tier">
                                @if (Auth::isAdmin())
                                    <li><a href="/admin">Admin</a></li>
                                @endif
								<li>
									<form method="post" action="/auth/logout">
                                        {!! csrf_field() !!}
										<input type="submit" value="Logout" />
									</form>
								</li>
							</ul>
						@else
							<a href="/auth/login">My Account</a>
							<ul class="nav-second-tier">
                                <li><a href="/auth/login">Log In</a></li>
                                <li><a href="/auth/signup">Sign Up</a></li>
							</ul>
						@endif
						</ul>
					</li>
				</ul>
			</nav>
	</header>
</div>

