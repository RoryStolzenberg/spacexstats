@extends('templates.main')
@section('title', 'User ' . $user->username)

@section('content')
<body class="profile">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}</h1>
        <main>
            <nav class="in-page sticky-bar">
                <ul class="container">
                    <li class="gr-1">
                        <a href="#overview">Overview</a>
                    </li>

                    <li class="gr-1">
                        <a href="#favorites">Favorites</a>
                    </li>

                    @if (Auth::isAccessingSelf($user))
                        <li class="gr-1">Notes</li>
                    @endif

                    <li class="gr-1">Uploads</li>

                    <li class="gr-1">Comments</li>

                    @if (Auth::isAccessingSelf($user))
                        <li class="gr-1"><a href="/users/{{ $user->username }}/edit"><i class="fa fa-pencil"></i></a></li>
                    @endif
                </ul>
            </nav>
            @if (Auth::isAccessingSelf($user))
                <h2>Your Interactions</h2>
                <section class="interactions">
                    <p>Here you can see what services and features of SpaceXStats you are using. To enable a feature, go to the edit profile page.</p>
                    @if (in_array(true, $interactions, true)))
                        <table>
                            <tr>
                                @foreach ($interactions as $interaction => $value)
                                    <td>
                                        @if ($value)
                                            <img src="/images/icons/interactions/{{ $interaction }} Active.png" />
                                        @else
                                            <img src="/images/icons/interactions/{{ $interaction }}.png" />
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($interactions as $interaction => $value)
                                    <td>
                                        @if ($value)
                                            <i class="fa fa-check"></i> {{ $interaction }}
                                        @else
                                            {{ $interaction }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    @else
                        <p class="exclaim"><a href="/users/{{ $user->username }}/edit">Edit your profile</a> to setup SMS & email notifications, and more.</p>
                    @endif
                </section>
            @endif

            <h2>Overview</h2>
            <section id="overview" class="overview scrollto container">
                <!-- About this user -->
                <div class="gr-8">
                    <table class="about-this-user">
                        <tr>
                            <td>Bio</td>
                            <td><div class="backing">{{ $user->profile->summary or 'Nothing here' }}</div></td>
                        </tr>
                        @if (!is_null($user->profile->twitter_account))
                        <tr>
                            <td><i class="fa fa-twitter"></i> Twitter</td>
                            <td>
                                <span><a href="https://twitter.com/{{ $user->profile->twitter_account }}">{{ '@' . $user->profile->twitter_account }}</a></span>
                            </td>
                        </tr>
                        @endif
                        @if (!is_null($user->profile->reddit_account))
                        <tr>
                            <td><i class="fa fa-reddit"></i> Reddit</td>
                            <td>
                                <span><a href="http://reddit.com/u/{{ $user->profile->reddit_account }}">{{ '/u/' . $user->profile->reddit_account }}</a></span>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>Member Since</td>
                            <td>
                                {{ $user->created_at->toFormattedDateString() }}
                            </td>
                        </tr>
                        <tr>
                            <td>Member Details</td>
                            <td>
                                {{ $user->present()->role_id() }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="gr-4">
                    <div class="delta-v-badge">
                        <p class="delta-v-count">{{ $user->totalDeltaV() }} <br/>
                            <small>m/s of deltaV</small>
                        </p>

                        @if ($user->subscriptionExtendedBy() > 0)
                            <p>{{ $user->username }} has extended their subscription by {{ $user->subscriptionExtendedBy(true) }}.</p>
                        @endif
                    </div>
                    <table class="user-stats">
                        <tr>
                            <td>Uploads</td>
                            <td>{{ $user->objects()->inMissionControl()->count() }}</td>
                        </tr>
                        <tr>
                            <td>Favorites</td>
                            <td>{{ $user->favorites->count() }}</td>
                        </tr>
                        <tr>
                            <td>Comments</td>
                            <td>{{ $user->comments->count() }}</td>
                        </tr>
                    </table>
                </div>

                <h3>Favorite Mission</h3>
                @if ($favoriteMission)
                    @include('templates.cards.missionCard', ['size' => 'small', 'mission' => $favoriteMission])
                @else
                    <p class="exclaim">No favorite mission. Add one!</p>
                @endif
                <div class="gr-12">

                    <div class="gr-6 gr-12@small">
                        <h3>Favorite Mission Patch</h3>
                        @if ($user->profile->favorite_misison_patch)
                            $user->profile->favorite_mission_patch
                        @else
                            <p class="exclaim">No Favorite Mission Patch. Add one!</p>
                        @endif
                    </div>
                    <div class="gr-6 gr-12@small">
                        <h3>Favorite Musk Quote</h3>
                        @if ($user->profile->favorite_quote)
                            <blockquote>{{ $user->profile->favorite_quote }}</blockquote>
                        @else
                            <p class="exclaim">No favorite Musk quote. Add one!</p>
                        @endif
                    </div>
                </div>
            </section>

            <h2><a href="/users/{{ $user->username }}/favorites">Favorites</a></h2>
            <section id="favorites" class="favorites scrollto container">
                    @foreach ($favorites as $favorite)
                        @include('templates.cards.objectCard', ['bias' => 'favorite', 'object' => $favorite->object])
                    @endforeach
                    @if ($favorites->count() == 0)
                        <p class="exclaim">Nothing to see here</p>
                    @endif
            </section>

            @if (Auth::isAccessingSelf($user))
                <h2>Notes</h2>
                <section id="notes" class="scrollto notes">
                    @foreach ($notes as $note)
                        @include('templates.cards.objectCard', ['bias' => 'note', 'object' => $note->object])
                    @endforeach
                    @if ($notes->count() == 0)
                        <p class="exclaim">Nothing to see here</p>
                    @endif
                </section>
            @endif

            <h2>Uploads</h2>
            <section id="uploads" class="scrollto uploads">
                @foreach ($objects as $object)
                    @include('templates.cards.objectCard', ['bias' => 'object', 'object' => $object])
                @endforeach
                @if ($objects->count() == 0)
                    <p class="exclaim">Nothing to see here.
                        @if (Auth::isAccessingSelf($user) && Auth::isSubscriber())
                            <a href="/missioncontrol/create">Why don't you upload something?</a>
                        @endif
                    </p>
                @endif
            </section>

            <h2>Comments</h2>
            <section id="comments" class="scrollto">
                @foreach ($comments as $comment)
                    @include('templates.cards.objectCard', ['bias' => 'comment', 'object' => $comment->object])
                @endforeach
                @if ($comments->count() == 0)
                    <p class="exclaim">Nothing to see here</p>
                @endif
            </section>
        </main>
    </div>
</body>
@stop

