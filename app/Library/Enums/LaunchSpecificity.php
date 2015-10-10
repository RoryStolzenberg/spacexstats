<?php
namespace SpaceXStats\Enums;

abstract class LaunchSpecificity extends Enum {
    const Precise       = 7; // Launch date time down to HH:MM:SS (use countdown)
    const Day           = 6; // Launch date only (use countdown)
    const SubMonth      = 5; // early March, mid March, late March
    const Month         = 4; // March, April, May
    const Quarter       = 3; // Q1, Q2, Q3, Q4
    const SubYear       = 2; // early 2017, mid 2017, late 2017
    const Half          = 1; // H1, H2
    const Year          = 0; // 2017
}