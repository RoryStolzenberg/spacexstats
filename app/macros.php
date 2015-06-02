<?php

Form::macro('richSelect', function($nameOfProperty, $selectListOptions, $params) {
	//http://laravel-tricks.com/tricks/getting-formmodel-values-in-custom-formmacros
	//http://stackoverflow.com/questions/20508893/laravel-4-formmacro-with-formmodel

	$defaultValue = Form::getValueAttribute($nameOfProperty);

	$params = (object)$params;
	echo '<div class="rich-select" id="'.$nameOfProperty.'" tabindex="0" data-value="'.$defaultValue.'">
		<div class="default">
			<img />
			<span class="title">
			</span>
		</div>
	<ul>';
	foreach ($selectListOptions as $selectListOption) {
		if ($selectListOption->{$params->identifier} == $defaultValue) {
			echo '<li data-value="'. $selectListOption->{$params->identifier}.'" class="default">';
		} else {
			echo '<li data-value="'. $selectListOption->{$params->identifier}.'">';
		}
				echo '<img src="/assets/images/backgrounds/atlasvula.jpg" />';
				echo '<span class="title">'.$selectListOption->{$params->title}.'</span>';
				//echo '<span class="summary">'.substr($option->{$params->summary}, 0, 100).'</span>';
			echo '</li>';			
	}
	echo '</ul></div>';
});

Form::macro('tags', function($nameOfProperty = null) {
	$defaultValue = Form::getValueAttribute($nameOfProperty);
	echo '<input type="text" class="tagger" id="'.$nameOfProperty.'" value="'.$defaultValue.'">';
});

// Form macro twitter edit
Form::macro('twitterCard', function($tweet) {
    echo '<div class="card twitter-card edit">';
    echo '</div>';
});

// Form macro date
Form::macro('date', function($nameOfProperty = null, $defaultDateArray = array(), $startYear = 1900, $options = array()) {

    $defaultDay = null;
    $defaultMonth = null;
    $defaultYear = null;

    // If there is a property containing date time info being passed through
    if ($nameOfProperty !== null) {
        $dateString = DateTime::createFromFormat('Y-m-d', Form::getValueAttribute($nameOfProperty));

        // If there is a date to be parsed
        if ($dateString !== false) {
            $defaultDay = $dateString->format('Y');
            $defaultMonth = $dateString->format('m');
            $defaultYear = $dateString->format('d');
        }

    // There is no usable date, pull in the defaults, if they are defined
    } else {
        if (array_key_exists('year', $defaultDateArray)) {
            $defaultYear = $defaultDateArray['year'];
        }

        if (array_key_exists('month', $defaultDateArray)) {
            $defaultMonth = $defaultDateArray['month'];
        }

        if (array_key_exists('day', $defaultDateArray)) {
            $defaultDay = $defaultDateArray['day'];
        }
    }

    // Check for any options (attributes, ids, classes, data-binds...)


    echo Form::selectRange('day', 1, 31, $defaultDay, $options['day']);
    echo Form::selectMonth('month', $defaultMonth, $options['month']);
    echo Form::selectRange('year', Carbon\Carbon::now()->year, $startYear, $defaultYear, $options['year']);

});