@extends('emails.template')

@section('emailType', 'Signup Request')
@section('emailBody')
<h2>Welcome to SpaceX Stats!</h2>

<p>You're one step away from access to the world's largest collection of SpaceX news, information, and resources.

<a href="http://spacexstats.com/auth/verify/{{ $id }}/{{ $key }}">Confirm your account details here</a>. Then, head on over and grab a subscription to <a href="http://spacexstats.com/missioncontrol">Mission Control</a>!
@stop