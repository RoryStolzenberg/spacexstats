@extends('templates.main')

@section('scripts')
{{ HTML::script('/assets/js/suggest.js') }}
<script type="text/javascript">
	$(document).ready(function() {
		$('input.tagger').suggest();		
	});
</script>
@stop

@section('content')
<div class="content-wrapper">
	<h1>Mission Control</h1>
	<main>
		{{ Form::open() }}
			{{ Form::label('tags', 'Tags') }}
			{{ Form::tags('tags', array('elon-musk')) }}
		{{ Form::close() }}
        <?php
            $ffprobe = FFMpeg\FFProbe::create([
                    'ffmpeg.binaries' => Credential::FFMpeg,
                    'ffprobe.binaries' => Credential::FFProbe
            ]);
            echo $ffprobe->format('media/video.flv')->get('duration');
        ?>
	</main>
</div>
@stop

