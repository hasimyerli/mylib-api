<?php


namespace App\Library\ElasticSearch;


use App\Constant\ElasticSearchConstant;
use App\Document\BookDocument;
use App\Library\ElasticSearch\Builder\Document\GetDocumentBuilder;
use App\Library\ElasticSearch\Builder\Document\SearchDocumentBuilder;
use App\Library\ElasticSearch\Event\Document\DeleteDocumentBuilder;
use App\Library\ElasticSearch\Event\Document\DeleteDocumentInterface;
use App\Library\ElasticSearch\Event\Document\GetDocumentInterface;
use App\Library\ElasticSearch\Event\ElasticSearchClientInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use ReflectionClass;

class ElasticSearchClient implements ElasticSearchClientInterface
{
    public static function build(): ElasticSearchClientInterface
    {
        return new ElasticSearchClient();
    }

    public function deleteDocument($documentClass, string $documentId): DeleteDocumentInterface
    {
        return new DeleteDocumentBuilder($documentClass, $documentId);
    }

    public function getDocument($documentClass, string $documentId): GetDocumentInterface
    {
        return new GetDocumentBuilder($documentClass, $documentId);
    }

    public function searchDocuments($documentClass): SearchDocumentBuilder
    {
        return new SearchDocumentBuilder($documentClass);
    }


}