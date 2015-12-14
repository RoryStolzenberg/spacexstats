<?php
namespace SpaceXStats\Presenters;

use Carbon\Carbon;

class MissionPresenter {

	protected $entity;

	function __construct($entity) {
		$this->entity = $entity;
	}

    public function launchDateTime($customFormat = null) {
        if ($this->entity->isLaunchPrecise()) {
            if ($customFormat) {
                return Carbon::parse($this->entity->launch_date_time)->format($customFormat);
            }
            return Carbon::parse($this->entity->launch_date_time)->format('g:i:sA F j, Y');
        } else {
            return $this->entity->launch_approximate;
        }
    }

	public function article() {
		if (empty($this->entity->article)) {
			return '<section id="article" class="scrollto">
						<article class="in-progress">
							<p class="exclaim"><i class="fa fa-newspaper-o fa-4x"></i> Article in progress. Check back soon!</p>
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

    public function featuredImageUrl() {
        if ($this->entity->featuredImage != null) {
            return $this->entity->featuredImage->media;
        } else {
            return '/images/missionbanners/' . $this->entity->missionType->name . '.jpg';
        }
    }

	public function launchProbability() {
		return round($this->entity->launchProbability * 100);
	}
}