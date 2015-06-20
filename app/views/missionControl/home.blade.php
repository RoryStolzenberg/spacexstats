@extends('templates.main')

@section('scripts')
<script data-main="/src/js/common" src="/src/js/require.js"></script>
<script>
    require(['common'], function() {
        require(['knockout', 'jquery'], function(ko, $) {

            var someViewModel = function() {
                ko.components.register('rich-select', {require: 'components/rich-select/rich-select'});
            };

            ko.applyBindings(someViewModel);
        });
    });
</script>
@stop

@section('content')
<div class="content-wrapper">
	<h1>Mission Control</h1>
	<main>
		<rich-select params="fetchFrom: '/missions/all', default: true, mapping: {}"></rich-select>
	</main>
</div>
@stop

