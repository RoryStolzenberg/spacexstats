<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Credential;

class SearchProvider {
    private $elasticSearchClient;

    public function __construct() {
        $this->elasticSearchClient = new Client(array(
            'hosts' => [Credential::ElasticSearchHost]
        ));
    }

    public function indexObject($object) {
        $params = [
            'index' => 'spacexstats',
            'type' => 'objects',
            'id' => $object->object_id,
            'body' => [
                'object_id' => $object->object_id,
                'user' => $object->user,
                'mission' => $object->mission,
                'title' => $object->title
            ]
        ];

        $obj = $this->elasticSearchClient->index($params);
        return $obj;
    }

    public function get() {
        return $this->$elasticSearchClient;
    }
}