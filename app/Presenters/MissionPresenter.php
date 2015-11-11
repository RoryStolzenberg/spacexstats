<?php
namespace SpaceXStats\Presenters;

class MissionPresenter {

	protected $entity;

	function __construct($entity) {
		$this->entity = $entity;
	}

    public function launchDateTime($format = 'j M Y G:i:s') {
        if ($this->entity->launch_approximate === null) {
            $dt = new \DateTime($this->entity->launch_exact);
            return $dt->format($format);
        } else {
            return $this->entity->launch_approximate;
        }
    }

    public function launchOfYear() {
        return $this->ordinal($this->entity->launchOfYear);
    }

	public function article() {
		if (empty($this->entity->article)) {
			return '<section id="article" class="scrollto">
						<article class="in-progress">
							<i class="fa fa-newspaper-o fa-5x"></i> <span>Article in progress. Check back soon!</span>
						</article>
					</section>';
		} else {
			return '<section>
						<article id="article" class="scrollto md">
						'.$this->entity->article_md.'
						</article>
					</section>';
		}
	}

    public function specificVehicleCount() {
        return $this->ordinal($this->entity->specificVehicleCount);
    }

    public function genericVehicleCount() {
        return $this->ordinal($this->entity->genericVehicleCount);
    }

    private function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if (($number %100) >= 11 && ($number%100) <= 13) {
            return $number. 'th';
        } else {
            return $number. $ends[$number % 10];
        }
    }
}