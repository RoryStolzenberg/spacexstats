<?php
namespace SpaceXStats\Presenters\Traits;

trait PresentableTrait {
	protected $presenterInstance;

	public function present() {

		if (!$this->presenter || !class_exists($this->presenter)) {
			throw new \Exception('Please set the protected $presenter property, or if it is set, run \'composer dump-autoload\'.');
		}

		if (!$this->presenterInstance) {
			$this->presenterInstance = new $this->presenter($this);
		}

		return $this->presenterInstance;
	}
}