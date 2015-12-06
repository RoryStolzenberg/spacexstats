<?php
namespace SpaceXStats\Search\Models;

use SpaceXStats\Search\Interfaces\SearchableInterface;

class SearchableObject implements SearchableInterface
{
    private $entity;
    private $indexType = 'objects';

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
            'object_id' => $this->entity->object_id,
            'user_id' => !$this->entity->anonymous ? $this->entity->user_id : null,
            'user' => [
                'user_id' => !$this->entity->anonymous ? $this->entity->user->user_id : null,
                'username' => !$this->entity->anonymous ? $this->entity->user->username : null
            ],
            'mission_id' => $this->entity->mission_id,
            'type' => $this->entity->type,
            'subtype' => $this->entity->subtype,
            'size' => $this->entity->size,
            'filetype' => $this->entity->filetype,
            'title' => $this->entity->title,
            'dimensions' => [
                'width' => $this->entity->dimension_width,
                'height' => $this->entity->dimension_height
            ],
            'duration' => $this->entity->duration,
            'summary' => $this->entity->summary,
            'author' => $this->entity->author,
            'attribution' => $this->entity->attribution,
            'originated_at' => $this->entity->originated_at->toIso8601String(),
            'tweet_user_name' => $this->entity->tweet_user_name,
            'tweet_text' => $this->entity->tweet_text,
            'status' => $this->entity->status,
            'visibility' => $this->entity->visibility,
            'anonymous' => $this->entity->anonymous,
            'orignal_content' => $this->entity->originalContent,
            'actioned_at' => $this->entity->actioned_at->toIso8601String(),
            'tags' => $this->entity->tags()->lists('name'),
            'favorites' => $this->entity->favorites()->lists('user_id'),
            'notes' => $this->entity->notes()->lists('user_id'),
            'downloads' => $this->entity->downloads()->lists('user_id')->unique()
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