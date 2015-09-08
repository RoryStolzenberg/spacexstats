<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Credential;

class Search {
    private $elasticSearchClient;

    public function __construct() {
        $this->elasticSearchClient = new Client(array(
            'hosts' => [Credential::ElasticSearchHost]
        ));
    }

    public function index($object) {

        $paramBody = [
            'object_id' => $object->object_id,
            'user_id' => $object->user_id,
            'user' => [
                'user_id' => $object->user->user_id,
                'username' => $object->user->username
            ],
            'mission_id' => $object->mission_id,
            'type' => $object->type,
            'subtype' => $object->subtype,
            'size' => $object->size,
            'filetype' => $object->filetype,
            'title' => $object->title,
            'dimensions' => [
                'width' => $object->dimension_width,
                'height' => $object->dimension_height
            ],
            'length' => $object->length,
            'summary' => $object->summary,
            'author' => $object->author,
            'attribution' => $object->attribution,
            'originated_at' => $object->originDateAsString,
            'tweet_user_name' => $object->tweet_user_name,
            'tweet_text' => $object->tweet_text,
            'status' => $object->status,
            'visibility' => $object->visibility,
            'anonymous' => $object->anonymous,
            'actioned_at' => $object->actioned_at->toDateTimeString(),
            'tags' => $object->tags()->lists('name')
        ];

        if ($object->mission()->count() == 1) {
            $paramBody['mission'] = [
                'mission_id' => $object->mission->mission_id,
                'name' => $object->mission->name
            ];
        } else {
            $paramBody['mission'] = [
                'mission_id' => null,
                'name' => null
            ];
        }

        $params = [
            'index' => 'spacexstats',
            'type' => 'objects',
            'id' => $object->object_id,
            'body' => $paramBody
        ];

        return $this->elasticSearchClient->index($params);
    }

    public function moreLikeThis() {

    }

    public function get() {
        return $this->$elasticSearchClient;
    }
}