<?php
namespace SpaceXStats\Search\Models;

use SpaceXStats\Search\Interfaces\SearchableInterface;

class SearchableCollection implements SearchableInterface
{
    private $entity;
    private $indexType = 'collections';

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
        $paramBody = [
            'collection_id' => $this->entity->collection_id,
            'creating_user' => [
                'user_id' => $this->entity->creating_user_id,
                'username' => $this->entity->user()->username
            ],
            'mission_id' => $this->entity->mission_id,
            'title' => $this->entity->title,
            'summary' => $this->entity->summary,
            'objects' => $this->entity->objects()->lists('object_id')
        ];

        if ($this->entity->mission()->count() == 1) {
            $paramBody['mission'] = [
                'mission_id' => $this->entity->mission->mission_id,
                'name' => $this->entity->mission->name
            ];
        } else {
            $paramBody['mission'] = [
                'mission_id' => null,
                'name' => null
            ];
        }
        return $paramBody;
    }

    public function getMapping() {
        return [

        ];
    }

}