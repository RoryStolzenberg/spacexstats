<?php
namespace SpaceXStats\Search;

use Elasticsearch\Client;
use Credential;
use Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use SpaceXStats\Models\User;
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

        // Add resource type filters
        if (!is_null($search['filters']['type'])) {
            $requestBody['filter']['bool']['should']['term']['type'] = strtolower($search['filters']['type']);
            $requestBody['filter']['bool']['should']['term']['subtype'] = strtolower($search['filters']['type']);
        }


        return $this->elasticSearchClient->search([
            'index' => Search::INDEX,
            'type' => $limitTypesToThese,
            'body' => $requestBody,
            'size' => 100
        ]);
    }

    public function reindex(SearchableInterface $model) {
        return $this->elasticSearchClient->update([
            'index' => Search::INDEX,
            'type' => $model->getIndexType(),
            'id' => $model->getId(),
            'body' => $model->index()
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