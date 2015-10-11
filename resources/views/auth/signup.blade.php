@extends('templates.main')
@section('title', 'Sign Up')

@section('content')
<body class="signup">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Join SpaceX Stats</h1>
        <main>
            <form>
                {!! csrf_token() !!}

                <label for="username">Username</label>
                <input type="text" name="username" id="username" />

                <label for="password">Password</label>
                <input type="password" id="password" name="password">

                <label for="eula">I agree to the terms and conditions</label>
                <input type="checkbox" name="eula" id="eula" value="true">

                <input type="submit" value="Sign Up">
            </form>
        </main>
    </div>
</body>
@stop