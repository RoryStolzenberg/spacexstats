<?php
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if (($number %100) >= 11 && ($number%100) <= 13) {
        return $number. 'th';
    } else {
        return $number. $ends[$number % 10];
    }
}

function create_if_does_not_exist($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
}