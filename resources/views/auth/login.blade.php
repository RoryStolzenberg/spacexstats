@extends('templates.main')
@section('title', 'Log In')

@section('content')
<body class="login">

    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Log In</h1>
        <main>

            <form action="/auth/login" method="post">
                {!! csrf_field() !!}

                <label for="email">Email</label>
                <input type="email" id="email" name="email" />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" />

                <input type="checkbox" id="remember" name="remember" />
                <label for="remember">Remember Me</label>

                <input type="submit" value="Log In" />
            </form>
        </main>
    </div>
</body>
@stop

