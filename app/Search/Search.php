<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Credential;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use SpaceXStats\Models\User;

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
     * @param $model
     * @return array
     */
    public function index(Model $model) {
        $classname = (new ReflectionClass($model))->getShortName();

        if ($classname == "Object") {
            $paramBody = [
                'object_id' => $model->object_id,
                'user_id' => $model->user_id,
                'user' => [
                    'user_id' => $model->user->user_id,
                    'username' => $model->user->username
                ],
                'mission_id' => $model->mission_id,
                'type' => $model->type,
                'subtype' => $model->subtype,
                'size' => $model->size,
                'filetype' => $model->filetype,
                'title' => $model->title,
                'dimensions' => [
                    'width' => $model->dimension_width,
                    'height' => $model->dimension_height
                ],
                'length' => $model->length,
                'summary' => $model->summary,
                'author' => $model->author,
                'attribution' => $model->attribution,
                'originated_at' => $model->originDateAsString,
                'tweet_user_name' => $model->tweet_user_name,
                'tweet_text' => $model->tweet_text,
                'status' => $model->status,
                'visibility' => $model->visibility,
                'anonymous' => $model->anonymous,
                'orignal_content' => $model->originalContent,
                'actioned_at' => $model->actioned_at->toDateTimeString(),
                'tags' => $model->tags()->lists('name'),
                'favorites' => $model->favorites()->lists('user_id'),
                'notes' => $model->notes()->lists('user_id'),
                'downloads' => $model->downloads()->lists('user_id')->unique()
            ];

            if ($model->mission()->count() == 1) {
                $paramBody['mission'] = [
                    'mission_id' => $model->mission->mission_id,
                    'name' => $model->mission->name
                ];
            } else {
                $paramBody['mission'] = [
                    'mission_id' => null,
                    'name' => null
                ];
            }
        } elseif ($classname == "DataView") {

        } else if ($classname == "Collection") {

        }

        $params = [
            'index' => Search::INDEX,
            'type' => 'objects',
            'id' => $model->object_id,
            'body' => $paramBody
        ];

        return $this->elasticSearchClient->index($params);
    }

    /**
     * @param $search
     * @param array $limitTypesToThese
     */
    public function search($search, $limitTypesToThese = null) {
        if ($limitTypesToThese == null) {
            $limitTypesToThese = 'objects,collections,dataviews';
        } else {

        }

        $requestBody['query'] = [
            'multi_match' => [
                'query'     => $search['searchTerm'],
                'fields'    => ['title^2', 'summary', 'tweet_text^0.5', 'article^0.5']
            ]
        ];

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

    public function delete(Model $model) {

    }

    /**
     *
     */
    public function moreLikeThis(Model $model, $take) {

    }

    /**
     * @return Client
     */
    public function client() {
        return $this->elasticSearchClient;
    }
}