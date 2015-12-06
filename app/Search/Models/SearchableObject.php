<?php
namespace SpaceXStats\Search\Models;

use SpaceXStats\Search\Interfaces\SearchableInterface;

class SearchableObject implements SearchableInterface
{
    private $entity;
    private $indexType = 'objects';

    public function getIndexType() {
        return $this->indexType;
    }

    public function getId() {
        return $this->entity->object_id;
    }

    public function index() {
        $paramBody = [
            'object_id' => $this->object_id,
            'user_id' => !$this->anonymous ? $this->user_id : null,
            'user' => [
                'user_id' => !$this->anonymous ? $this->user->user_id : null,
                'username' => !$this->anonymous ? $this->user->username : null
            ],
            'mission_id' => $this->mission_id,
            'type' => $this->type,
            'subtype' => $this->subtype,
            'size' => $this->size,
            'filetype' => $this->filetype,
            'title' => $this->title,
            'dimensions' => [
                'width' => $this->dimension_width,
                'height' => $this->dimension_height
            ],
            'duration' => $this->duration,
            'summary' => $this->summary,
            'author' => $this->author,
            'attribution' => $this->attribution,
            'originated_at' => $this->originated_at->toIso8601String(),
            'tweet_user_name' => $this->tweet_user_name,
            'tweet_text' => $this->tweet_text,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'anonymous' => $this->anonymous,
            'orignal_content' => $this->originalContent,
            'actioned_at' => $this->actioned_at->toIso8601String(),
            'tags' => $this->tags()->lists('name'),
            'favorites' => $this->favorites()->lists('user_id'),
            'notes' => $this->notes()->lists('user_id'),
            'downloads' => $this->downloads()->lists('user_id')->unique()
        ];

        if ($this->mission()->count() == 1) {
            $paramBody['mission'] = [
                'mission_id' => $this->mission->mission_id,
                'name' => $this->mission->name
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