@extends('templates.main')
@section('title', 'Reset Your Password')

@section('content')
    <body class="reset-password">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Reset Your Password</h1>
        <main>
            <form method="post" action="/users/resetpassword">
                <ul>
                    <li>
                        <label for="">Password</label>
                        <input type="password" name="password" id="password" />
                    </li>
                    <li>
                        <input type="submit" value="Reset Password" />
                    </li>
                </ul>
            </form>
        </main>
    </div>
    </body>
@stop
