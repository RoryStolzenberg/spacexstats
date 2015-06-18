@extends('templates.main')

@section('scripts')
<script data-main="/src/js/common" src="/src/js/require.js"></script>
<script>
    require(['common'], function() {
        require(['knockout', 'jquery'], function(ko, $) {

            /*var someViewModel = function() {
                ko.components.register('tags', {require: 'components/richSelect/richSelect'});
            };

            ko.applyBindings(someViewModel);*/

            $.ajax('missions/all', {
                success: function(missions) {
                    console.log(missions);
                }
            })
        });
    });
</script>
@stop

@section('content')
<div class="content-wrapper">
	<h1>Mission Control</h1>
	<main>
		<richSelect></richSelect>
	</main>
</div>
@stop

