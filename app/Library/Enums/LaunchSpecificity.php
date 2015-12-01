<?php
namespace SpaceXStats\Library\Enums;

abstract class LaunchSpecificity extends Enum {
    const Precise       = 7; // Launch date time down to HH:MM:SS (use countdown)
    const Day           = 6; // Launch date only (use countdown)
    const SubMonth      = 5; // Early March 2015, mid March 2015, late March 2015
    const Month         = 4; // March 2016, April 2016, May 2016
    const Quarter       = 3; // Q1, Q2 2017, Q3 2017, Q4 2017
    const SubYear       = 2; // early 2018, mid 2018, late 2018
    const Half          = 1; // H1 2019, H2 2019
    const Year          = 0; // 2020
}