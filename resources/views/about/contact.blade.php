@extends('templates.main')
@section('title', 'Contact')

@section('content')
    <body class="contact">

    @include('templates.header')

    <div class="content-wrapper">
        <h1>Contact</h1>
        <main>
            <h2>Email</h2>
            <p>If you have a query or tip, please contact us directly using one of the emails below:</p>

            <h3>General contact & feedback</h3>
            <p>For issues relating to your account including billing, general feedback, and enquiries:</p>
            <a href="mailto:contact@spacexstats.com">contact@spacexstats.com</a>

            <h3>Tips & Information</h3>
            <p>If you have a tipoff or want to provide information, contact us here. All tips & sources are treated securely.</p>
            <a href="mailto:info@spacexstats.com">info@spacexstats.com</a>

            <h3>Website Bugs, Issues, and Security</h3>
            <p>For issues relating to SpaceXStats' functionality and operation, if you find or a bug, error, or security vulnerability, please contact:</p>
            <a href="mailto:webmaster@spacexstats.com">webmaster@spacexstats.com</a>

        </main>
    </div>
    </body>
@stop