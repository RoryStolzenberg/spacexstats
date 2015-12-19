@extends('templates.main')
@section('title', 'Mission Control')

@section('content')
<body class="missioncontrol-about" ng-app="aboutMissionControlApp" ng-controller="aboutController" ng-cloak>

    @include('templates.header', ['class' => 'no-background'])

    <div class="content-wrapper single-page background transparent">
        <h1 class="text-center">Launching in 2016: Mission Control</h1>
        <main>
            <section class="subscribe" ng-controller="subscriptionController">
                <p>Stay on the leading edge of SpaceX updates, browse vast amounts of images, videos, documents, and articles. In depth statistics and mission analysis.</p>
                <p>All you need to do is buy me a cup of coffee every few months.</p>

                @if (!Auth::check())
                <div class="plan free">
                    <h2>Sign Up For Free</h2>
                    <div class="features">
                        <p>Just like before, email launch notifications remain free.</p>
                        <a href="/auth/signup" class="wide-button button">Launching In 2016</a>
                    </div>
                </div>
                @endif
                <div class="plan subscription">
                    <h2>Mission Control - $9/year</h2>
                    <div class="features" ng-show="subscriptionState.isLooking">
                        <ul>
                            <li>SMS/Email Launch Notifications</li>
                            <li>Archive Access</li>
                            <li>GBs of content</li>
                            <li>Indepth Statistics & DataViews</li>
                            <li>Mission Analytics</li>
                            <li>Community Access</li>
                        </ul>
                        @if (Auth::isMember())
                            <button class="wide-button white" ng-click="subscription.showSubscribeForm()">Launching In 2016</button>
                        @else
                            <a href="/auth/signup" class="button wide-button white">Launching In 2016</a>
                        @endif
                    </div>
                    @if (Auth::isMember())
                        <form name="subscribeForm" ng-show="subscriptionState.isEnteringDetails || subscriptionState.isSubscribing" novalidate>
                            <fieldset ng-disabled="subscriptionState.isSubscribing">
                                <ul>
                                    <li>
                                        <img src="/images/paymentoptions.png" class="payment-options" />
                                    </li>
                                    <li>
                                        <input type="text" name="creditcardnumber" ng-model="creditcard.number" cc-format cc-number data-stripe="number" placeholder="Card Number" />
                                    </li>
                                    <li class="container" cc-exp>
                                        <label>Expiry Month & Year</label>
                                        <input class="gr-6" type="text" name="creditcardexpiry" ng-model="creditcard.expiry.month" cc-exp-month placeholder="MM" data-stripe="exp-month"/>
                                        <input class="gr-6" type="text" name="creditcardexpiry" ng-model="creditcard.expiry.year" cc-exp-year placeholder="YYYY" full-year data-stripe="exp-year" />
                                    </li>
                                    <li>
                                        <input type="text" name="creditcardcvc" ng-model="creditcard.cvc" placeholder="CVC" cc-cvc data-stripe="cvc" />
                                    </li>
                                    <li>
                                        <button class="wide-button white" ng-click="subscription.subscribe($event)" ng-disabled="subscriptionState.isSubscribing || subscribeForm.$invalid"><i class="fa fa-lock"></i> @{{ subscriptionButtonText }}</button>
                                        <p class="subscription-failed text-left small" ng-show="subscriptionState.failed">That didn't work. Try again?</p>
                                    </li>
                                </ul>
                            </fieldset>
                        </form>
                        <div class="response" ng-show="subscriptionState.hasSubscribed">
                            <p>Payment Complete!</p>
                            <a class="button wide-button" href="/missioncontrol">Go To Mission Control</a> <!-- Make button text fade and change -->
                        </div>
                    @endif
                </div>

                <!--<p>Scroll down to see why Mission Control is so awesome.</p>-->
            </section>
        </main>
    </div>
    <!--<div class="content-wrapper single-page background transparent" style="position:relative;overflow:hidden;">
        <video autoplay loop id="herovideo">
            <source src="/videos/herovideo.mp4" type="video/mp4">
        </video>
        <h1>We Have Liftoff</h1>
    </div>
    <div class="content-wrapper single-page background transparent notifications">
        <h1>Text & Email Notifications</h1>
        <main>
            <div class="gr-4">
                <p>With Mission Control, you can receive SMS & email notifications at 24, 3, and 1 hour intervals before a launch. Don't ever miss a SpaceX launch again!</p>
            </div>
            <div class="gr-4 float-right">
                <img class="sms-notification" src="/images/smsnotifications.png" alt="Receive SMS notifications about upcoming launches on your phone" />
            </div>


        </main>
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
        <p>You will never pay more for Mission Control, you will always be charged at the rate that was available when you signed up (excluding inflation).</p>
        <p>At the end of the year or when your subscription expires (whichever is later), you will be automatically rebilled.</p>
    </div>-->

    @if (Auth::check())
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('{{ $stripePublicKey }}');
    </script>
    @endif
</body>
@stop

