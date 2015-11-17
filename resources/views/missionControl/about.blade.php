@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about" ng-app="aboutMissionControlApp">

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background transparent">
        <h1 class="center">Mission Control</h1>
        <main>
            <section class="subscribe" ng-controller="subscriptionController">
                <p>Stay on the leading edge of SpaceX updates, browse vast amounts of images, videos, documents, and articles. In depth statistics and mission analysis</p>
                <p>All you need to do is buy me a cup of coffee every few months.</p>

                <div class="plan free">
                    <span>Free</span>
                    <div class="features">
                        <p>Just like before, email launch notifications remain free.</p>
                        <a class="button">Sign Up</a>
                    </div>
                </div>
                <div class="plan subscription">
                    <span>$9/year</span>
                    <div class="features">
                        <ul>
                            <li>SMS/Email Launch Notifications</li>
                            <li>Archive Access</li>
                            <li>Indepth Statistics & DataViews</li>
                            <li>Mission Analytics</li>
                            <li>Community Access</li>
                        </ul>
                        <button ng-click="showSubscribeForm">Sign Me Up!</button>
                    </div>
                    <form name="subscribeForm">
                        <label for="Card Number">Card Number</label>
                        <input type="text" name="creditcardnumber" ng-model="creditcard.number" credit-card-validator="number" />
                        <input type="text" name="creditcardexpiry" ng-model="creditcard.expiry" credit-card-validator="expiry" placeholder="MM/YY" />
                        <input type="text" name="creditcardcvc" ng-model="creditcard.cvc" credit-card-validator="cvc" placeholder="CVC" />

                        <button ng-click="subscription.subscribe(creditcard)"><i class="fa fa-lock"></i> Pay $9</button>
                    </form>
                    <div class="response">
                        Payment Complete!

                        <a class="button">Go To Mission Control</a>
                    </div>
                </div>

                <p>You will never pay more for Mission Control, you will always be charged at the rate that was available when you signed up (excluding inflation).</p>
                <p>At the end of the year or when your subscription expires (whichever is later), you will be automatically rebilled.</p>
            </section>
            <p>Scroll down to see why Mission Control is so awesome.</p>
        </main>
    </div>
    <div class="content-wrapper single-page background transparent">
        <h1>Text & Email Notifications</h1>
    </div>
    <div class="content-wrapper single-page background transparent">
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

