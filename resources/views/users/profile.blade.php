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

            <section class="highlights">
                <ul>
                    <li>SMS messages</li>
                    <li>Launch changes</li>
                    <li>Upcoming launches</li>
                    <li>News Sumamries</li>
                    <li>Favorite Mission</li>
                    <li>Favorite Patch</li>
                </ul>
            </section>

            <section id="overview" class="overview container">
                <div class="gr-8">
                    <table>
                        <tr>
                            <td class="lowvisibility color">Bio</td>
                            <td><div class="backing">{{ $user->profile->summary or 'Nothing here' }}</div></td>
                        </tr>
                        @if (!is_null($user->profile->twitter_account))
                        <tr>
                            <td class="lowvisibility color"><i class="fa fa-twitter"></i> Twitter</td>
                            <td>{{ '@' . $user->profile->twitter_account }}</td>
                        </tr>
                        @endif
                        @if (!is_null($user->profile->reddit_account))
                        <tr>
                            <td class="lowvisibility color"><i class="fa fa-reddit"></i> Reddit</td>
                            <td>{{ '/u/' . $user->profile->reddit_account }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="lowvisibility color">Member Since</td>
                            <td>
                                {{ $user->created_at->toFormattedDateString() }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lowvisibility color">Member Details</td>
                            <td>
                                {{ $user->present()->role_id() }}
                            </td>
                        </tr>

                    </table>
                </div>

                <div class="gr-4">
                    <div>
                        <span>2154</span><small>m/s</small><br/>
                        <span>of DeltaV</span>
                    </div>
                    <table>
                        <tr>
                            <td class="lowvisibility color">Uploads</td>
                            <td>{{ $user->objects()->inMissionControl()->count() }}</td>
                        </tr>
                        <tr>
                            <td class="lowvisibility color">Favorites</td>
                            <td>{{ $user->favorites->count() }}</td>
                        </tr>
                        <tr>
                            <td class="lowvisibility color">Comments</td>
                            <td>{{ $user->comments->count() }}</td>
                        </tr>
                    </table>
                </div>

                <div class="gr-12">
                    <table>
                        <tr>
                            <td class="lowvisibility color">Favorite Mission</td>
                            <td>
                                @if ($favoriteMission)
                                    @include('templates.missionCard', ['size' => 'small', 'mission' => $favoriteMission])
                                @else
                                    <p>No favorite mission. Add one!</p>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td class="lowvisibility color">Favorite Mission Patch</td>
                            <td>
                                {{ $user->profile->favorite_mission_patch or 'No Favorite Mission Patch. Add one!' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="lowvisibility color">Favorite Elon Musk Quote</td>
                            <td>
                                @if ($user->profile->favorite_quote)
                                    <blockquote>{{ $user->profile->favorite_quote }}</blockquote>
                                @else
                                    No favorite quote. Add one!
                                @endif
                            </td>

                        </tr>
                    </table>

                </div>
            </section>

            <h2><a href="/users/{{ $user->username }}/favorites">Favorites</a></h2>
            <section id="favorites" class="favorites container">
                    @foreach ($favorites as $favorite)
                        @include('templates.objectCard', ['bias' => 'favorite', 'object' => $favorite->object])
                    @endforeach
                    @if ($favorites->count() == 0)
                        <p class="exclaim">Nothing to see here</p>
                    @endif
            </section>

            @if (Auth::isAccessingSelf($user) || Auth::isAdmin())
                <h2>Notes</h2>
                <section id="notes" class="notes">
                    @foreach ($notes as $note)
                        @include('templates.objectCard', ['bias' => 'note', 'object' => $note->object])
                    @endforeach
                    @if ($notes->count() == 0)
                        <p class="exclaim">Nothing to see here</p>
                    @endif
                </section>
            @endif

            <h2>Uploads</h2>
            <section id="uploads" class="uploads">
                @foreach ($objects as $object)
                    @include('templates.objectCard', ['bias' => 'object', 'object' => $object])
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
            <section id="comments" class="">
                @foreach ($comments as $comment)
                    @include('templates.objectCard', ['bias' => 'comment', 'object' => $comment->object])
                @endforeach
                @if ($comments->count() == 0)
                    <p class="exclaim">Nothing to see here</p>
                @endif
            </section>
        </main>
    </div>
</body>
@stop

