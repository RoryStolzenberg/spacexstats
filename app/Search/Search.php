<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use SpaceXStats\Search\Interfaces\SearchableInterface;

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
    public function index(SearchableInterface $model) {
        return $this->elasticSearchClient->index([
            'index' => Search::INDEX,
            'type' => $model->getIndexType(),
            'id' => $model->getId(),
            'body' => $model->index()
        ]);
    }

    /**
     * @param $search
     * @param array $limitTypesToThese
     */
    public function search($search, $limitTypesToThese = null) {
        if ($limitTypesToThese == null) {
            $limitTypesToThese = 'objects,collections,dataviews';
        }

        $requestBody['query'] = [
            'multi_match' => [
                'query'     => $search['searchTerm'],
                'fields'    => ['title^2', 'summary', 'tweet_text', 'article^0.5']
            ]
        ];

        // Add mission filters
        if (!is_null($search['filters']['mission'])) {
            $requestBody['filter']['bool']['should']['term']['mission.name'] = strtolower($search['filters']['mission']);
        }

        // Add tag filters
        if (count($search['filters']['tags']) > 0) {
            $requestBody['filter']['bool']['should']['terms'] = [
                "tags" => array_map("strtoLower", $search['filters']['tags']),
                "minimum_should_match" => 1
            ];
        }

        // Add submission type filters
        if (!is_null($search['filters']['type'])) {
            $requestBody['filter']['bool']['should']['term']['type'] = strtolower($search['filters']['type']);
            $requestBody['filter']['bool']['should']['term']['subtype'] = strtolower($search['filters']['type']);
        }

        // Add favorite filters
        // Add noted filters
        // Add download filters

        // Add before filters
        // Add after filters

        $results = $this->elasticSearchClient->search([
            'index' => Search::INDEX,
            'type' => $limitTypesToThese,
            'body' => $requestBody,
            'size' => 100
        ]);

        // For each result, we need to loop over and fetch a
    }

    public function reindex(SearchableInterface $model) {
        return $this->elasticSearchClient->update([
            'index' => Search::INDEX,
            'type' => $model->getIndexType(),
            'id' => $model->getId(),
            'body' => $model->index()
        ]);
    }

    public function bulkReindex(array $models) {
        // because elasticsearch bulk is dumb
        $bulkString = "";

        foreach ($models as $model) {
            if ((new ReflectionClass($model))->implementsInterface('SpaceXStats\Search\Interfaces\SearchableInterface')) {
                $updateCommand = ['update' => [
                    "_index" => Search::INDEX,
                    "_type" => $model->getIndexType(),
                    "_id" => $model->getId(),
                    "_retry_on_conflict" => 3
                ]];

                $bulkString .= json_encode($updateCommand) . "\n";
                $bulkString .= json_encode(['doc' => $model->index()]) . "\n";
            } else {
                throw new \Exception("Model does not implement SearchableInterface");
            }
        }

        return $this->elasticSearchClient->bulk([
            'index' => Search::INDEX,
            'type' => $models[0]->getIndexType(),
            'body' => $bulkString
        ]);
    }

    public function delete(SearchableInterface $model) {

    }

    public function moreLikeThis(SearchableInterface $model, $take = null) {
        if (is_null($take)) {
            $take = 10;
        }

        $results = $this->elasticSearchClient->search([
            'index' => Search::INDEX,
            'type' => $model->getIndexType(),
            'body' => [
                'query' => [
                    'more_like_this' => [
                        'fields' => ['title', 'summary', 'tags'],
                        "min_term_freq" => 0,
                        "min_doc_freq" => 0,
                        'docs' => [
                            [
                                "_index" => Search::INDEX,
                                "_type" => $model->getIndexType(),
                                "_id" => $model->getId()
                            ]
                        ]
                    ]
                ],
                "size" => 10
            ]
        ]);

        return $results['hits']['hits'];
    }

    /**
     * @return Client
     */
    public function client() {
        return $this->elasticSearchClient;
    }
}