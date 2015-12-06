<?php
namespace SpaceXStats\Search\Traits;

trait SearchableTrait {
    protected $searchableInstance;

    public function search() {

        if (!$this->searchDecorator || !class_exists($this->searchDecorator)) {
            throw new \Exception('Please set the protected $searchDecorator property, or if it is set, run \'composer dump-autoload\'.');
        }

        if (!$this->searchableInstance) {
            $this->searchableInstance = new $this->searchDecorator($this);
        }

        return $this->searchableInstance;
    }
}