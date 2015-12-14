<?php
namespace SpaceXStats\Search\Models;

use SpaceXStats\Search\Interfaces\SearchableInterface;

class SearchableDataView implements SearchableInterface
{
    private $entity;
    private $indexType = 'dataviews';

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function getIndexType() {
        return $this->indexType;
    }

    public function getId() {
        return $this->entity->object_id;
    }

    public function index() {
        return [
            'dataview_id' => $this->entity->dataview_id,
            'user_id' => $this->entity->user_id,
            'user' => [
                'user_id' => $this->entity->user_id,
                'username' => $this->entity->user()->username
            ],
            'name' => $this->entity->name,
            'column_titles' => $this->entity->column_titles,
            'query' => $this->entity->query,
            'summary' => $this->entity->summary,
            'dark_color' => $this->entity->dark_color,
            'light_color' => $this->entity->light_color
        ];
    }

    public function getMapping() {
        return [

        ];
    }

}