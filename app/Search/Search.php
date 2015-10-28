<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Credential;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Models\Object;

class Search {

    const INDEX = 'spacexstats';

    private $elasticSearchClient;

    /**
     *
     */
    public function __construct() {
        $this->elasticSearchClient = ClientBuilder::create()->setHosts(
            [env('ELASTICSEARCH_HOST')]
        )->build();
    }

    /**
     * @param $object
     * @return array
     */
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
            'tags' => $object->tags()->lists('name'),
            'favorites' => $object->favorites()->list('user_id'),
            'notes' => $object->notes()->list('user_id'),
            'downloads' => $object->downloads()->list('user_id')->unique()
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
            'index' => Search::INDEX,
            'type' => 'objects',
            'id' => $object->object_id,
            'body' => $paramBody
        ];

        return $this->elasticSearchClient->index($params);
    }

    /**
     * @param $search
     * @param null $limitTypesTo
     */
    public function search($search, $limitTypesToThese = null) {
        if ($limitTypesToThese == null) {
            $limitTypesToThese = 'objects,collections,dataviews';
        }

        $requestBody = array();

        $requestBody['query'] = array(
            'multi_match' => array(
                'query'     => $search['searchTerm'],
                'fields'    => array('title^2', 'summary', 'tweet_text', 'article')
            )
        );

        // Add filters
        if ($search['filters']['mission'] != null) {
            $requestBody['filter']['bool']['must']['term']['mission.name'] = strtolower($search['filters']['mission']);
        }

        return $this->elasticSearchClient->search(array(
            'index' => Search::INDEX,
            'type' => $limitTypesToThese,
            'body' => $requestBody
        ));
    }

    public function reindex(Model $model) {

    }

    /**
     *
     */
    public function moreLikeThis(Model $model) {

    }

    /**
     * @return Client
     */
    public function get() {
        return $this->elasticSearchClient;
    }
}