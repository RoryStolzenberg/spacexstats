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
            <p>For issues relating to your account including billing, general feedback, suggestions, and enquiries:<br/>
            <a href="mailto:contact@spacexstats.com">contact@spacexstats.com</a></p>

            <h3>Tips & Information</h3>
            <p>If you have a tipoff, want to provide information, or have a query about something you'd like to upload, contact us here. All tips & sources are treated securely.<br/>
            <a href="mailto:info@spacexstats.com">info@spacexstats.com</a></p>

            <h3>Website Bugs, Issues, and Security</h3>
            <p>For issues relating to SpaceXStats' functionality and operation, if you find or a bug, error, or security vulnerability, please contact:<br/>
            <a href="mailto:development@spacexstats.com">development@spacexstats.com</a></p>
        </main>
    </div>
    </body>
@stop