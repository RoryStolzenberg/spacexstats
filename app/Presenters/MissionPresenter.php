<?php
namespace SpaceXStats\Presenters;

use Carbon\Carbon;

class MissionPresenter {

	protected $entity;

	function __construct($entity) {
		$this->entity = $entity;
	}

    public function launchDateTime() {
        if ($this->entity->isLaunchPrecise()) {
            return Carbon::parse($this->entity->launch_date_time)->format('g:i:sA F j, Y');
        } else {

        }
        if ($this->entity->launch_approximate === null) {
            $dt = new \DateTime($this->entity->launch_exact);
            return $dt->format();
        } else {
            return $this->entity->launch_approximate;
        }
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

    public function featuredImageUrl() {
        if ($this->entity->featuredImage != null) {
            return $this->entity->featuredImage->media;
        } else {
            return '/images/missionbanners/' . $this->entity->missionType->name . '.jpg';
        }
    }
}