@extends('templates.main')

@section('title', 'Locations')
@section('bodyClass', 'locations')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require([], function() {
            });
        });
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Locations</h1>
        <main>
            <canvas>

            </canvas>
        </main>
    </div>
@stop