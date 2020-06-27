<?php


namespace App\Library\ElasticSearch\Builder\Document;


use App\Constant\ElasticSearchConstant;
use App\Document\BookDocument;
use App\Library\ElasticSearch\Event\Document\SearchDocumentInterface;
use ReflectionClass;

class SearchDocumentBuilder extends DocumentBuilder implements SearchDocumentInterface
{
    private int $size = ElasticSearchConstant::DEFAULT_LIMIT;
    private array $body = [];

    public function addQueryMatch($field, $value): SearchDocumentInterface
    {
        $this->initQuery();
        $this->body['query'] = [
            'match' => [
                $field => $value
            ]
        ];

        return $this;
    }

    public function setSize(int $size): SearchDocumentInterface
    {
        $this->size = $size;
        return $this;
    }

    public function setSort($field, $order): SearchDocumentInterface
    {
       // $body['sort'][] = $field . ':' . $order;
        $body['aggs'] = array(
            array('title' => array('order' => 'desc')),
        );
        return $this;
    }

    public function get()
    {
        $params = $this->getBaseParams();
        $params['body'] = $this->body;
        $params['size'] = $this->size;

        $result = $this->client->search($params);

        $hits = $result['hits']['hits'];
        $total = $result['hits']['total']['value'];

        $results = [];

        $className = $this->documentClass;

        foreach ($hits as $hit)
        {
            $results[] = new $className($hit['_source']);
        }

        $booksResult = new \stdClass();
        $booksResult->results = $results;
        $booksResult->total = $total;
        return $booksResult;
    }

    private function initQuery()
    {
        $body['query'] = $body['query'] ?? [];
    }
}