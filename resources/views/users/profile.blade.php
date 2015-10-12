@extends('templates.main')
@section('title', 'User ' . $user->username)

@section('content')
<body class="profile">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $user->username }}</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="gr-1"><a href="#overview">Overview</a></li>
                    <li class="gr-1"><a href="#favorites">Favorites</a></li>
                    @if (Auth::check() && Auth::user()->username === $user->username)
                        <li class="gr-1">Notes</li>
                    @endif
                    <li class="gr-1">Uploads</li>
                    <li class="gr-1">Comments</li>
                    @if (Auth::check() && Auth::user()->username === $user->username)
                        <li class="gr-1"><a href="/users/{{ $user->username }}/edit"><i class="fa fa-pencil"></i></a></li>
                    @endif
                </ul>
            </nav>
            <section id="overview" class="overview container">
                <div class="gr-4">
                    <table>
                        <tr>
                            <td>Bio</td>
                            <td>{{ $user->profile->summary }}</td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td>{{ $user->profile->twitter_account }}</td>
                        </tr>
                        <tr>
                            <td>Reddit</td>
                            <td>{{ $user->profile->reddit_account }}</td>
                        </tr>
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
                        <tr>
                            <td>Uploads</td>
                            <td>{{ $user->publishedObjects()->count() }}</td>
                        </tr>
                        <tr>
                            <td>Favorites</td>
                            <td>{{ $user->favorites->count() }}</td>
                        </tr>
                        <tr>
                            <td>Comments</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="gr-8">
                    <table>
                        <tr>
                            <td>Favorite Mission</td>
                            <td>
                                @if ($favoriteMission)
                                    @include('templates.missionCard', ['size' => 'small', 'mission' => $favoriteMission])
                                @else
                                    <p>No favorite mission. Add one!</p>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td>Favorite Mission Patch</td>
                            <td>{{ $user->profile->favorite_mission_patch }}</td>
                        </tr>
                        <tr>
                            <td>Favorite Elon Musk Quote</td>
                            <td>{{ $user->profile->favorite_quote }}</td>
                        </tr>
                    </table>

                </div>
            </section>

            <h2><a href="/users/{{ $user->username }}/favorites">Favorites</a></h2>
            <section id="favorites" class="favorites container">
                    @foreach ($favorites as $favorite)
                        @include('templates.objectCard', ['bias' => 'favorite', 'object' => $favorite->object])
                    @endforeach
            </section>

            @if (Auth::isAccessingSelf($user) || Auth::isAdmin())
                <h2>Notes</h2>
                <section id="notes" class="notes">
                    @foreach ($notes as $note)
                        @include('templates.objectCard', ['bias' => 'note', 'object' => $note->object])
                    @endforeach
                </section>
            @endif

            <h2>Uploads</h2>
            <section id="uploads" class="uploads">
                @foreach ($objects as $object)
                    @include('templates.objectCard', ['bias' => 'object', 'object' => $object])
                @endforeach
            </section>

            <h2>Comments</h2>
            <section id="comments" class="comments">

            </section>
        </main>
    </div>
</body>
@stop

