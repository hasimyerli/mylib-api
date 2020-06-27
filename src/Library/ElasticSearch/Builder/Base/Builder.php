<?php


namespace App\Library\ElasticSearch\Builder;


use App\Constant\ElasticSearchConstant;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Builder
{
    protected Client $client;

    public function __construct()
    {
        // getenv('ELASTICSEARCH_HOST') . ":" . getenv('ELASTICSEARCH_PORT') Todo: get from env

        $this->client = ClientBuilder::create()
            ->setHosts([
                "elasticsearch:9200"
            ])
            ->setRetries(ElasticSearchConstant::RETRY_COUNT)
            ->build();
    }

}