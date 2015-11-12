@extends('templates.main')
@section('title', 'Log In')

@section('content')
<body class="login">

    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Log In</h1>
        <main>

            <form action="/auth/login" method="post" class="container">
                {!! csrf_field() !!}

                <ul class="gr-4@large gr-12@small gr-centered">
                    <li>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" />
                    </li>
                    <li>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" />
                    </li>
                    <li>
                        <input type="checkbox" id="remember" name="remember" />
                        <label for="remember"><span class="label">Remember Me</span></label>
                    </li>
                    <li>
                        <input type="submit" value="Log In" />
                    </li>
                </ul>

            </form>
        </main>
    </div>
</body>
@stop

