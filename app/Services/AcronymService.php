<?php
namespace SpaceXStats\Services;

class AcronymService
{
    // todo: add relevant acronyms from http://www.decronym.xyz/acronyms/SpaceX.json
    protected $acronyms = [
        'AGL' => 'Above Ground Level'
    ];

    public function parseAndExpand($input, $replace = false) {

        if ($replace) {
            foreach ($this->acronyms as $acronym => $expansion) {
                $input = str_replace($acronym, $expansion, $input);
            }
        } else {
            foreach ($this->acronyms as $acronym => $expansion) {
                $input = str_replace($acronym, $acronym . '(' . $expansion . ')', $input);
            }
        }
        return $input;
    }
}