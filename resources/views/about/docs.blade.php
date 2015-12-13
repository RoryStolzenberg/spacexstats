@extends('templates.main')
@section('title', 'Docs')

@section('content')
    <body class="publisher-get">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Docs</h1>
        <main>
            <nav class="sticky-bar in-page">
                <ul class="container">
                    <li class="gr-2">SpaceX Stats</li>
                    <li class="gr-2">Mission Control</li>
                </ul>
            </nav>

            <p>If you have a query or tip, <a href="/about/contact">please contact us directly</a>.</p>

            <h2>SpaceX Stats</h2>
            <section id="spacexstats" class="scrollto">
            </section>

            <h2>Mission Control</h2>
            <section id="missioncontrol" class="scrollto">
                <p class="exclaim">Mission Control is currently in private beta and will be launching in 2016.</p>
                <!--<h3>Submissions</h3>
                <h4>What text fields support markdown formatting?</h4>
                <p>SpaceX Stats uses GitHub-flavored Markdown</p>

                <h3>DeltaV</h3>
                <h4>What is DeltaV?</h4>
                <p>DeltaV forms the basis of the rewards system for Mission Control subscribers who contribute content to the site.</p>

                <h4>How is DeltaV calculated?</h4>
                <p></p>

                <h4>How does DeltaV affect my Mission Control subscription?</h4>

                <h3>My Account & Subscriptions</h3>
                <h4></h4>-->
            </section>
        </main>
    </div>
    </body>
@stop