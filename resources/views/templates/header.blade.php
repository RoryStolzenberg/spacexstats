<div class="header-wrapper {{ $class or null }}" style="background-image:url({{ $backgroundImage or null }})">
	<header class="text-center">
			<i class="fa fa-navicon toggleMobileNavigation gridle-show-small"></i>
			<span id="logo"><a href="/">SpaceX Stats</a></span>
			<nav>		
				<ul>
                    <li class="gr-1on8 gr-small-12">
                        <a href="/live">Live</a>
                    </li>
					<li class="gr-1on8 gr-small-12">
						{{ link_to_route('missions.past', 'Past Missions') }}
						<ul class="nav-second-tier wide">
							@foreach ($nearbyMissions['past'] as $pastMission)
							<li>{{ link_to_route('missions.get', $pastMission->name, $pastMission->slug) }}</li>
							@endforeach
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12">
						{{ link_to_route('missions.future', 'Future Missions') }}
						<ul class="nav-second-tier wide">
							@foreach ($nearbyMissions['future'] as $futureMission)
							<li>{{ link_to_route('missions.get', $futureMission->name, $futureMission->slug) }}</li>
							@endforeach
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12">
						More...
						<ul class="nav-second-tier wide">
                            <li>{{ link_to_route('locations', 'Locations') }}</li>
							<li>News Summaries</li>
							<li>{{ link_to_route('faq', 'Frequently Asked Questions') }}</li>
							<li>RSS Updates</li>
                            <li>Community</li>
							<li>About</li>
							<li>Contact</li>
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12 push-3">
						{{ link_to_route('missionControl', 'Mission Control') }}
						<ul class="nav-second-tier">
							@if (Auth::isSubscriber())
								<li>{{ link_to_route('missionControl.create', 'Upload') }}</li>
                                <li>Collections</li>
								<li>Leaderboards</li>
							@else 	
							    <li>{{ link_to_route('missionControl.buy', 'Buy')}}</li>
							@endif
							<li><a href="/docs#missioncontrol">Docs</a></li>
                            @if (Auth::isAdmin())
                                <li>{{ link_to_route('missionControl.review.index', 'Review') }}</li>
                            @endif
						</ul>
					</li>
					<li class="gr-1on8 gr-small-12 push-3">
						@if (Auth::check())
							{{ link_to_route('users.get', Auth::user()->username, array(Auth::user()->username)) }}
							<ul class="nav-second-tier">
                                @if (Auth::isAdmin())
                                    <li>{{ link_to_route('admin', 'Admin') }}</li>
                                @endif
								<li>
									<form method="post" action="/users/logout">
										<input type="submit" value="Logout" />
									</form>
								</li>		
							</ul>				
						@else
							My Account
							<ul class="nav-second-tier">
                                <li>{{ link_to_route('users.login', 'Log In') }}</li>
                                <li>{{ link_to_route('users.signup', 'Sign Up') }}</li>
							</ul>
						@endif
						</ul>
					</li>
				</ul>	
			</nav>		
	</header>
</div>

