@extends('templates.main')
@section('title', 'Sign Up')

@section('content')
<body class="signup">

    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Join SpaceX Stats</h1>
        <main>
            <div class="gr-6">
                <form name="signUpForm" novalidate>
                    {!! csrf_field() !!}

                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" min="6" required />

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" min="6" required>

                    <input type="checkbox" name="eula" id="eula" value="true" required>
                    <label for="eula">I have read & agree to the terms and conditions</label>

                    <input type="submit" value="Sign Up" ng-disabled="signUpForm.$invalid">
                </form>
            </div>
        </main>
    </div>
</body>
@stop