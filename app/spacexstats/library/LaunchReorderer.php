<?php
namespace SpaceXStats\Library;

class LaunchReorderer {
	protected $scheduledLaunch;

	public function __construct($scheduledLaunch, $currentLaunchOrderId = null) {
		$this->scheduledLaunch = $scheduledLaunch;
        $this->currentLaunchOrderId = $currentLaunchOrderId;
	}

	public function run() {
        // If the launch is being created
        if (is_null($this->currentLaunchOrderId)) {
            if ($this->isLastLaunch()) {

            } else {

            }

        // If the launch is being edited and already has an order
        } else {
            if ($this->reorderNeeded()) {

            } else {

            }
        }
    }

    // If a launch is being added, check if it is at the end. No need to sort.
    private function isLastLaunch() {
        // Grab the last mission, as ordered by launch_order_id
        $lastMission = Mission::orderBy('launch_order_id')->take(1)->get();
        $lastMissionDt = new LaunchDateTime($lastMission->launch_date_time, $lastMission->launch_specificity);

        // Parse this mission into a LaunchDateTime
        $thisMissionDt = $this->parseStringDate($this->scheduledLaunch);

        // If this mission is ahead of the last mission
        if ($this->compare($thisMissionDt, $lastMissionDt) === 1) {
            return true;
        } else {
            return false;
        }

    }

    // If a launch is being edited, check if it differs from those around it. No need to sort.
	private function reorderNeeded() {
		$beforeLaunchIsStillBefore = $this->compareLaunches($this->scheduledLaunch, Mission::pastMissions($this->reference['launch_id'] - 1)->get()->scheduled_launch);
		$afterLaunchIsStillAfter = $this->compareLaunches($this->scheduledLaunch, Mission::pastMissions($this->reference['launch_id'] + 1)->get()->scheduled_launch);

        if ($beforeLaunchIsStillBefore && $afterLaunchIsStillAfter) {
            return false;
        } else {
            return true;
        }
	}

    // comparison function for usort()
    private function compare(LaunchDateTime $firstLdt, LaunchDateTime $secondLdt) {
        // first launch will occur before the second launch
        if ($firstLdt->getDateTime() < $secondLdt->getDateTime()) {
            return -1;
        // first launch will occur after the second launch
        } elseif ($firstLdt->getDateTime() > $secondLdt->getDateTime()) {
            return 1;
        // both launches are at the same time; resolve via launch specificity!
        } elseif ($firstLdt->getDateTIme() == $secondLdt->getDateTime()) {

            // First launch has a greater specificity than the second launch, occurs first
            if ($firstLdt->getSpecificity() > $secondLdt->getSpecificity()) {
                return -1;
            // First launch has a lower specificity than the second launch, occurs after
            } elseif ($firstLdt->getSpecificity() > $secondLdt->getSpecificity()) {
                return 1;
            // Same specificities, same dates. Use name of launch to resolve
            } elseif ($firstLdt->getSpecificity() == $secondLdt->getSpecificity()) {

            }
        }
    }

	private function sort() {

	}

    private function updateDatabase() {

    }

    // Todo: detect number of days in month based off year (for February) :((
	public function parseStringDate($dateToBeParsed) {
        $dateToBeParsed = trim($dateToBeParsed);

        // Attempt to create the date from a MYSQL-formatted datetime
        if (DateTime::createFromFormat("Y-m-d H:i:s", $dateToBeParsed) !== false) {
            return new LaunchDateTime(DateTime::createFromFormat("Y-m-d H:i:s", $dateToBeParsed), LaunchSpecificity::Precise);
        } else {
            // Declare the clauses and their associated values if they need to be used
            $dateMappings = array(
                'SubMonth' => array(
                    'early' => '-10 23:59:59',
                    'mid' => '-20 23:59:59',
                    'late' => ' 23:59:59'
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
                    'early' => '-04-30 23:59:59',
                    'mid' => '-08-31 23:59:59',
                    'late' => '-12-31 23:59:59'
                ),
                'Half' => array(
                    'H1' => '-06-30 23:59:59',
                    'H2' => '-12-31 23:59:59'
                )
            );
            // Check if it matches the SubMonth or SubYear specificities
            foreach (array('early','mid','late') as $subClause) {
                // If the string contains a 'early'/'mid'/'late' clause...
                if (strpos($dateToBeParsed, $subClause) !== false) {
                    // If the string also contains a year after the clause...
                    if (ctype_digit(substr($dateToBeParsed, strlen($subClause) + 1))) {

                        $creationString = substr($dateToBeParsed, strlen($subClause) + 1).$dateMappings['SubYear'][$subClause];
                        $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                        return new LaunchDateTime($dt, LaunchSpecificity::SubYear);

                    // Assume the string is "submonth"
                    } else {
                        $parsedMonth = substr($dateToBeParsed, strlen($subClause) + 1);

                        $parsedNumericalMonth = DateTime::CreateFromFormat('F',$parsedMonth)->format('m');
                        $currentNumericalMonth = (new DateTime())->format('m');

                        // If the month in the string is greater than the current month, assume current year or otherwise assume next year
                        $year = ($parsedNumericalMonth >= $currentNumericalMonth) ? date("Y") : date("Y") + 1;

                        // Get the number of days in the month for the year
                        if ($subClause === 'late') {
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $parsedNumericalMonth, $year);
                            $creationString = $year.'-'.$parsedNumericalMonth.'-'.$daysInMonth.$dateMappings['SubMonth'][$subClause];
                        } else {
                            $creationString = $year.'-'.$parsedNumericalMonth.$dateMappings['SubMonth'][$subClause];
                        }

                        $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                        return new LaunchDateTime($dt, LaunchSpecificity::SubMonth);
                    }
                }
            }

            // Check if the dateToBeParsed matches a month
            foreach ($dateMappings['Month'] as $month => $monthDate) {
                if (strpos($dateToBeParsed, $month) !== false) {

                    // Either take the year from the string explicitly or...
                    $parsedYear = substr($dateToBeParsed, strlen($month) + 1) ? substr($dateToBeParsed, strlen($month)) : false;

                    // assume either the current year or the next year based on the current month and the given month
                    if ($parsedYear === false) {
                        $parsedNumericalMonth = DateTime::CreateFromFormat('F',$month)->format('m');
                        $currentNumericalMonth = (new DateTime())->format('m');

                        // If the month in the string is greater than the current month, assume current year or otherwise assume next year
                        $parsedYear = ($parsedNumericalMonth >= $currentNumericalMonth) ? date("Y") : date("Y") + 1;
                    }

                    // Special case for February because leapyears are a thing
                    if ($month === 'February') {
                        $monthDate = '-02-'.cal_days_in_month(CAL_GREGORIAN, 2, $parsedYear).$monthDate;
                    }

                    $creationString = $parsedYear.$monthDate;
                    $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                    return new LaunchDateTime($dt, LaunchSpecificity::Month);
                }
            }

            // Check if the dateToBeParsed matches a quarterly specificity
            foreach (array('Q1', 'Q2', 'Q3', 'Q4') as $quarter) {
                if (strpos($dateToBeParsed, $quarter) !== false) {
                    $creationString = substr($dateToBeParsed, 3).$dateMappings['Quarter'][$quarter];
                    $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                    return new LaunchDateTime($dt, LaunchSpecificity::Half);
                }
            }

            // Check if the dateToBeParsed matches a half specificity
            foreach (array('H1','H2') as $half) {
                if (strpos($dateToBeParsed, $half) !== false) {
                    $creationString = substr($dateToBeParsed, 3).$dateMappings['Half'][$half];
                    $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                    return new LaunchDateTime($dt, LaunchSpecificity::Half);
                }
            }

            // Check if the date matched a year
            if (ctype_digit($dateToBeParsed) && strlen($dateToBeParsed) === 4) {
                $creationString = $dateToBeParsed.'-12-31 23:59:59';
                $dt = DateTime::createFromFormat("Y-m-d H:i:s", $creationString);
                return new LaunchDateTime($dt, LaunchSpecificity::Year);
            }

        }
	}
}