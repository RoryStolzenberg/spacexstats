@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about">

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background">
        <h1>Mission Control - The best blah blah</h1>
        <main>
            <p>Stay on the leading edge of SpaceX updates, browse vast amounts of images, videos, documents, and articles. In depth statistics and mission analysis</p>
            <p>All you need to do is buy me a cup of coffee every few months.</p>
            <section>
                <div class="plan free">
                    <span>Free</span>
                </div>
                <div class="plan subscription">
                    <span>$9/year</span>
                </div>
            </section>
            <p>Scroll down to see why Mission Control is so awesome.</p>
        </main>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Text & Email Notifications</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Gigabytes Of Archived Content</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Heroic Search</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Noted. And Commented. And Shared.</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Unparalleled Analytics</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>A dedicated spaceflight community awaits</h1>
    </div>
    <div class="content-wrapper single-page background">
        <h1>Convinced? Sign Me Up!</h1>
    </div>

</body>
@stop

