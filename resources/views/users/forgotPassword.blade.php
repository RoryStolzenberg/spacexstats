@extends('templates.main')
@section('title', 'Forgot Password')

@section('content')
    <body class="forgot-password">


    @include('templates.header')

    <div class="content-wrapper">
        <h1>Forgot Your Password?</h1>
        <main>
            <form method="post" action="/users/forgotpassword">
                <ul>
                    <li>
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" />
                    </li>
                    <li>
                        <input type="submit" value="Request" />
                    </li>
                </ul>
            </form>
        </main>
    </div>
    </body>
@stop
