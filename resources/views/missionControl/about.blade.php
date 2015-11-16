@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about">

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background">
        <h1>Mission Control - The best blah blah</h1>
        <main>
            <section ng-app="subscriptionApp" ng-controller="subscriptionController">
                <p>Stay on the leading edge of SpaceX updates, browse vast amounts of images, videos, documents, and articles. In depth statistics and mission analysis</p>
                <p>All you need to do is buy me a cup of coffee every few months.</p>

                <div class="plan free">
                    <span>Free</span>
                </div>
                <div class="plan subscription">
                    <span>$9/year</span>
                    <form name="subscribeForm">
                        <input type="text" name="creditcardnumber" ng-model="creditcard.number" credit-card-validator="number" />
                        <input type="text" name="creditcardexpiry" ng-model="creditcard.expiry" credit-card-validator="expiry" />
                        <input type="text" name="creditcardcvc" ng-model="creditcard.cvc" credit-card-validator="cvc" />

                        <input type="submit" value="Sign Up ->" ng-click="subscription.subscribe(creditcard)" />
                    </form>
                </div>

                <p>You will never pay more for Mission Control, you will always be charged at the rate that was available when you signed up (excluding inflation).</p>
                <p>At the end of the year or when your subscription expires (whichever is later), you will be automatically rebilled.</p>
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

