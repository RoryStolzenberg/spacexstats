<?php
namespace SpaceXStats\Library\Launch;

use Carbon\Carbon;
use SpaceXStats\Library\Enums\LaunchSpecificity;

abstract class LaunchDateTimeResolver {
    public static function parseString($dateToBeParsed) {
        $dateToBeParsed = trim($dateToBeParsed);

        // Attempt to create the date from a MYSQL-formatted datetime
        if (\DateTime::createFromFormat("Y-m-d H:i:s", $dateToBeParsed) !== false) {
            return new LaunchDateTime(\DateTime::createFromFormat("Y-m-d H:i:s", $dateToBeParsed), LaunchSpecificity::Precise);
        } else {
            // Declare the clauses and their associated values if they need to be used
            $dateMappings = array(
                'SubMonth' => array(
                    'Early' => '-10 23:59:59',
                    'Mid' => '-20 23:59:59',
                    'Late' => ' 23:59:59'
                ),
                'Month' => array(
                    'January' => '-01-31 23:59:59',
                    'February' => ' 23:59:59',
                    'March' => '-03-31 23:59:59',
                    'April' => '-04-30 23:59:59',
                    'May' => '-05-31 23:59:59',
                    'June' => '-06-30 23:59:59',
                    'July' => '-07-31 23:59:59',
                    'August' => '-08-31 23:59:59',
                    'September' => '-09-30 23:59:59',
                    'October' => '-10-31 23:59:59',
                    'November' => '-11-31 23:59:59',
                    'December' => '-12-31 23:59:59'
                ),
                'Quarter' => array(
                    'Q1' => '-03-31 23:59:59',
                    'Q2' => '-06-30 23:59:59',
                    'Q3' => '-09-30 23:59:59',
                    'Q4' => '-12-31 23:59:59'
                ),
                'SubYear' => array(
                    'Early' => '-04-30 23:59:59',
                    'Mid' => '-08-31 23:59:59',
                    'Late' => '-12-31 23:59:59'
                ),
                'Half' => array(
                    'H1' => '-06-30 23:59:59',
                    'H2' => '-12-31 23:59:59'
                )
            );
            // Check if it matches the SubMonth or SubYear specificities
            foreach (array('Early','Mid','Late') as $subClause) {
                // If the string contains a 'early'/'mid'/'late' clause...
                if (stripos($dateToBeParsed, $subClause) !== false) {
                    // If the string also contains a year directly after the sub clause... (Early 2017)
                    if (ctype_digit(substr($dateToBeParsed, strlen($subClause) + 1))) {

                        $creationString = substr($dateToBeParsed, strlen($subClause) + 1).$dateMappings['SubYear'][$subClause];
                        return new LaunchDateTime($creationString, LaunchSpecificity::SubYear);

                    // Assume the string is "submonth" (Early May 2015)
                    } else {
                        $monthYear = Carbon::createFromFormat('F Y', substr($dateToBeParsed, strlen($subClause) + 1));

                        // Get the number of days in the month for the year
                        if ($subClause === 'Late') {
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthYear->format('m'), $monthYear->format('Y'));
                            $creationString = $monthYear->format('Y').'-'.$monthYear->format('m').'-'.$daysInMonth.$dateMappings['SubMonth'][$subClause];
                        } else {
                            $creationString = $monthYear->format('Y').'-'.$monthYear->format('m') . $dateMappings['SubMonth'][$subClause];
                        }

                        return new LaunchDateTime($creationString, LaunchSpecificity::SubMonth);
                    }
                }
            }

            // Check if the dateToBeParsed matches a month
            foreach ($dateMappings['Month'] as $month => $monthDate) {
                if (stripos($dateToBeParsed, $month) !== false) {

                    $monthYear = Carbon::createFromFormat('F Y', $dateToBeParsed);

                    // Special case for February because leapyears are a thing
                    if ($month === 'February') {
                        $monthDate = '-02-'.cal_days_in_month(CAL_GREGORIAN, 2, $monthYear->format('Y')).$monthDate;
                    }

                    $creationString = $monthYear->format('Y').$monthDate;
                    return new LaunchDateTime($creationString, LaunchSpecificity::Month);
                }
            }

            // Check if the dateToBeParsed matches a quarterly specificity (Q1 2015)
            foreach (array('Q1', 'Q2', 'Q3', 'Q4') as $quarter) {
                if (strpos($dateToBeParsed, $quarter) !== false) {
                    $creationString = substr($dateToBeParsed, -4).$dateMappings['Quarter'][$quarter];
                    return new LaunchDateTime($creationString, LaunchSpecificity::Quarter);
                }
            }

            // Check if the dateToBeParsed matches a half specificity (H2 2015)
            foreach (array('H1','H2') as $half) {
                if (strpos($dateToBeParsed, $half) !== false) {
                    $creationString = substr($dateToBeParsed, -4).$dateMappings['Half'][$half];
                    return new LaunchDateTime($creationString, LaunchSpecificity::Half);
                }
            }

            // Check if the date matched a year
            if (ctype_digit($dateToBeParsed) && strlen($dateToBeParsed) === 4) {
                $creationString = $dateToBeParsed.'-12-31 23:59:59';
                return new LaunchDateTime($creationString, LaunchSpecificity::Year);
            }
        }
    }
}
