@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about" ng-app="aboutMissionControlApp">

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background transparent">
        <h1 class="text-center">Mission Control</h1>
        <main>
            <section class="subscribe" ng-controller="subscriptionController">
                <p>Stay on the leading edge of SpaceX updates, browse vast amounts of images, videos, documents, and articles. In depth statistics and mission analysis.</p>
                <p>All you need to do is buy me a cup of coffee every few months.</p>

                @if (!Auth::check())
                <div class="plan free">
                    <span>Sign Up For Free</span>
                    <div class="features">
                        <p>Just like before, email launch notifications remain free.</p>
                        <a href="/auth/signup" class="button">Sign Up</a>
                    </div>
                </div>
                @endif
                <div class="plan subscription">
                    <span>$9/year</span>
                    <div class="features">
                        <ul>
                            <li>SMS/Email Launch Notifications</li>
                            <li>Archive Access</li>
                            <li>GBs of content</li>
                            <li>Indepth Statistics & DataViews</li>
                            <li>Mission Analytics</li>
                            <li>Community Access</li>
                        </ul>
                        @if (Auth::isMember())
                            <button ng-click="showSubscribeForm">Lets Go!</button>
                        @else
                            <a href="/auth/signup" class="button">Sign Up</a>
                        @endif
                    </div>
                    @if (Auth::isMember())
                        <form name="subscribeForm">
                            <label for="Card Number">Card Number</label>
                            <input type="text" name="creditcardnumber" ng-model="creditcard.number" credit-card-validator="number" data-stripe="number" />
                            <input type="text" name="creditcardexpiry" ng-model="creditcard.expiry.month" credit-card-validator="expirymonth" placeholder="MM/YY" data-stripe="exp-month"/>
                            <input type="text" name="creditcardexpiry" ng-model="creditcard.expiry.year" credit-card-validator="expiryyear" placeholder="MM/YY" data-stripe="exp-year" />
                            <input type="text" name="creditcardcvc" ng-model="creditcard.cvc" credit-card-validator="cvc" placeholder="CVC" data-stripe="cvc" />

                            <button ng-click="subscription.subscribe($event)" ng-disabled="isSubscribing"><i class="fa fa-lock"></i> Pay $9</button>
                        </form>
                        <div class="response">
                            Payment Complete!

                            <a class="button">Go To Mission Control</a> <!-- Make button text fade and change -->
                        </div>
                    @endif
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

    @if (Auth::check())
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('{{ $stripePublicKey }}');
    </script>
    @endif
</body>
@stop

