<?php
namespace SpaceXStats\Search\Models;

use SpaceXStats\Search\Interfaces\SearchableInterface;

class SearchableObject implements SearchableInterface
{
    private $entity;
    private $indexName = 'objects';

    public function getIndexName() {
        return $this->indexName;
    }

    public function getId() {
        return $this->entity->object_id;
    }

    public function index() {

    }
}