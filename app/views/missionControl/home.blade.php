@extends('templates.main')

@section('scripts')
<script data-main="/src/js/common" src="/src/js/require.js"></script>
<script>
    require(['common'], function() {
        require(['knockout'], function(ko) {

            var someViewModel = function() {
                ko.components.register('tags', {require: 'components/tags/tags'});
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
		{{ Form::open() }}
			{{ Form::label('tags', 'Tags') }}
			<tags params="tags: 'elon-musk'"></tags>
		{{ Form::close() }}
	</main>
</div>
@stop

