<?php
@extends('templates.main')

@section('title', $user->username . '\'s Uploads')
@section('bodyClass', 'profile-uploads')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['jquery', 'knockout', 'viewmodels/UserUploadsViewModel'], function($, ko, UserUploadsViewModel) {
                $(document).ready(function() {
                    ko.applyBindings(new UserUploadsViewModel());
                });
            });
        });
    </script>
@stop