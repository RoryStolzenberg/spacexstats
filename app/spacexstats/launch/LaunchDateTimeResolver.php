<?php
namespace SpaceXStats\Launch;

use SpaceXStats\Enums\LaunchSpecificity;

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
            foreach (array('early','mid','late') as $subClause) {
                // If the string contains a 'early'/'mid'/'late' clause...
                if (stripos($dateToBeParsed, $subClause) !== false) {
                    // If the string also contains a year after the clause...
                    if (ctype_digit(substr($dateToBeParsed, strlen($subClause) + 1))) {

                        $creationString = substr($dateToBeParsed, strlen($subClause) + 1).$dateMappings['SubYear'][$subClause];
                        return new LaunchDateTime($creationString, LaunchSpecificity::SubYear);

                        // Assume the string is "submonth"
                    } else {
                        $parsedMonth = substr($dateToBeParsed, strlen($subClause) + 1);

                        $parsedNumericalMonth = \DateTime::CreateFromFormat('F',$parsedMonth)->format('m');
                        $currentNumericalMonth = (new \DateTime())->format('m');

                        // If the month in the string is greater than the current month, assume current year or otherwise assume next year
                        $year = ($parsedNumericalMonth >= $currentNumericalMonth) ? date("Y") : date("Y") + 1;

                        // Get the number of days in the month for the year
                        if ($subClause === 'late') {
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $parsedNumericalMonth, $year);
                            $creationString = $year.'-'.$parsedNumericalMonth.'-'.$daysInMonth.$dateMappings['SubMonth'][$subClause];
                        } else {
                            $creationString = $year.'-'.$parsedNumericalMonth.$dateMappings['SubMonth'][$subClause];
                        }

                        return new LaunchDateTime($creationString, LaunchSpecificity::SubMonth);
                    }
                }
            }

            // Check if the dateToBeParsed matches a month
            foreach ($dateMappings['Month'] as $month => $monthDate) {
                if (stripos($dateToBeParsed, $month) !== false) {

                    // Either take the year from the string explicitly or...
                    $parsedYear = substr($dateToBeParsed, strlen($month) + 1) ?: false;

                    // assume either the current year or the next year based on the current month and the given month
                    if ($parsedYear === false) {
                        $parsedNumericalMonth = \DateTime::CreateFromFormat('F',$month)->format('m');
                        $currentNumericalMonth = (new \DateTime())->format('m');

                        // If the month in the string is greater than the current month, assume current year or otherwise assume next year
                        $parsedYear = ($parsedNumericalMonth >= $currentNumericalMonth) ? date("Y") : date("Y") + 1;
                    }

                    // Special case for February because leapyears are a thing
                    if ($month === 'February') {
                        $monthDate = '-02-'.cal_days_in_month(CAL_GREGORIAN, 2, $parsedYear).$monthDate;
                    }

                    $creationString = $parsedYear.$monthDate;
                    return new LaunchDateTime($creationString, LaunchSpecificity::Month);
                }
            }

            // Check if the dateToBeParsed matches a quarterly specificity
            foreach (array('Q1', 'Q2', 'Q3', 'Q4') as $quarter) {
                if (strpos($dateToBeParsed, $quarter) !== false) {
                    $creationString = substr($dateToBeParsed, 3).$dateMappings['Quarter'][$quarter];
                    return new LaunchDateTime($creationString, LaunchSpecificity::Half);
                }
            }

            // Check if the dateToBeParsed matches a half specificity
            foreach (array('H1','H2') as $half) {
                if (strpos($dateToBeParsed, $half) !== false) {
                    $creationString = substr($dateToBeParsed, 3).$dateMappings['Half'][$half];
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
