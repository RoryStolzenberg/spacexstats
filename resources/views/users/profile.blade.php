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
                    <div class="text-center">
                        @foreach ($interactions as $interaction => $value)
                            @if ($value)
                                <img src="/images/icons/interactions/{{ $interaction }}active.png" />
                            @else
                                <img src="/images/icons/interactions/{{ $interaction }}.png" />
                            @endif
                        @endforeach
                        @if (!in_array(true, $interactions, true))
                            <p class="exclaim"><a href="/users/{{ $user->username }}/edit">Edit your profile</a> to setup SMS & email notifications, and more.</p>
                        @endif
                    </div>
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
                            <td><a href="https://twitter.com/{{ $user->profile->twitter_account }}">{{ '@' . $user->profile->twitter_account }}</a></td>
                        </tr>
                        @endif
                        @if (!is_null($user->profile->reddit_account))
                        <tr>
                            <td><i class="fa fa-reddit"></i> Reddit</td>
                            <td><a href="http://reddit.com/u/{{ $user->profile->reddit_account }}">{{ '/u/' . $user->profile->reddit_account }}</a></td>
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
                    <div>
                        <p><span>{{ $user->totalDeltaV() }}</span><small>m/s</small><br/> of DeltaV</p>

                        <p>{{ $user->username }} has extended their subscription by {{ $user->subscriptionExtendedBy() }}.</p>
                    </div>
                    <table class="about-this-user">
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

                <div class="gr-12">
                    <div class="gr-4 gr-6@medium gr-12@small">
                        @if ($favoriteMission)
                            @include('templates.cards.missionCard', ['size' => 'small', 'mission' => $favoriteMission])
                        @else
                            <p>No favorite mission. Add one!</p>
                        @endif
                    </div>
                    <div class="gr-4 gr-6@medium gr-12@small">
                        {{ $user->profile->favorite_mission_patch or 'No Favorite Mission Patch. Add one!' }}
                    </div>
                    <div class="gr-4 gr-6@medium gr-12@small">
                        @if ($user->profile->favorite_quote)
                            <blockquote>{{ $user->profile->favorite_quote }}</blockquote>
                        @else
                            No favorite quote. Add one!
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

