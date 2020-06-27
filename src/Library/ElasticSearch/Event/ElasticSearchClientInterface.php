<?php


namespace App\Library\ElasticSearch\Event;

use App\Library\ElasticSearch\Event\Document\DeleteDocumentInterface;
use App\Library\ElasticSearch\Event\Document\GetDocumentInterface;
use App\Library\ElasticSearch\Event\Document\SearchDocumentInterface;

interface ElasticSearchClientInterface
{
    public function deleteDocument($documentClass, string $documentId): DeleteDocumentInterface;
    public function getDocument($documentClass, string $documentId): GetDocumentInterface;
    public function searchDocuments($documentClass): SearchDocumentInterface;
}