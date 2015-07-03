<?php

// Form macro date
Form::macro('date', function($nameOfProperty = null, $defaultDateArray = null, $startYear = 1900, $options = array()) {

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

        if ($defaultDateArray !== null) {
            $now = \Carbon\Carbon::now();

            $defaultDay = $now->format('d');
            $defaultMonth = $now->format('m');
            $defaultYear = $now->format('y');
        }
    }

    // Check for any options (attributes, ids, classes, data-binds...)
    $options['day'] = (!array_key_exists('day', $options)) ? array() : $options['day'];
    $options['month'] = (!array_key_exists('month', $options)) ? array() : $options['month'];
    $options['year'] = (!array_key_exists('year', $options)) ? array() : $options['year'];


    echo Form::selectRange('day', 1, 31, $defaultDay, $options['day']);
    echo Form::selectMonth('month', $defaultMonth, $options['month']);
    echo Form::selectRange('year', Carbon\Carbon::now()->year, $startYear, $defaultYear, $options['year']);

});