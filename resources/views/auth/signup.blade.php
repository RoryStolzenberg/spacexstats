@extends('templates.main')
@section('title', 'Sign Up')

@section('content')
<body class="signup" ng-controller="signUpController" ng-strict-di>

    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Join SpaceX Stats</h1>
        <main>
            <div class="gr-6">
                <form name="signUpForm" novalidate>
                    {!! csrf_field() !!}

                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" min="6" ng-model="user.username" required />

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" ng-model="user.email" required />

                    <label for="password">Password</label>
                    <input type="password" password-toggle ng-model="user.password" required />

                    <input type="checkbox" name="eula" id="eula" value="true" ng-model="user.eula" required>
                    <label for="eula">I have read & agree to the terms and conditions</label>

                    <input type="submit" value="Sign Up" ng-disabled="signUpForm.$invalid">
                </form>
            </div>
        </main>
    </div>
</body>
@stop