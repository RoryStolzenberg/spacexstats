@extends('templates.main')
@section('title', 'Change Your Password')

@section('content')
    <body class="change-password">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>Change Your Password</h1>
        <main>
            <form method="post" action="/users/changepassword">
                <ul>
                    <li>
                        <label for="">Email</label>
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
