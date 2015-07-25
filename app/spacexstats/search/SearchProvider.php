<?php
namespace SpaceXStats\Search;

class SearchProvider {
    public function connect() {
        return new Elasticsearch\Client(array(
            'hosts' => [Credential::ElasticSearchHost]
        ));
    }
}