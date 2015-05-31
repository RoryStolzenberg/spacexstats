<?php

Form::macro('richSelect', function($name, $options, $params) {
	//http://laravel-tricks.com/tricks/getting-formmodel-values-in-custom-formmacros
	//http://stackoverflow.com/questions/20508893/laravel-4-formmacro-with-formmodel

	$defaultValue = Form::getValueAttribute($name);

	$params = (object)$params;
	echo '<div class="rich-select" id="'.$name.'" tabindex="0" data-value="'.$defaultValue.'">
		<div class="default">
			<img />
			<span class="title">
			</span>
		</div>
	<ul>';
	foreach ($options as $option) {
		if ($option->{$params->identifier} == $defaultValue) {
			echo '<li data-value="'. $option->{$params->identifier}.'" class="default">';
		} else {
			echo '<li data-value="'. $option->{$params->identifier}.'">';
		}
				echo '<img src="/assets/images/backgrounds/atlasvula.jpg" />';
				echo '<span class="title">'.$option->{$params->title}.'</span>';
				//echo '<span class="summary">'.substr($option->{$params->summary}, 0, 100).'</span>';
			echo '</li>';			
	}
	echo '</ul></div>';
});

Form::macro('tags', function($name = null) {
	$defaultValue = Form::getValueAttribute($name);
	echo '<input type="text" class="tagger" id="'.$name.'" value="'.$defaultValue.'">';
});