<?php


namespace App\Library\ElasticSearch\Event\Document;


use App\Library\ElasticSearch\Builder\Builder;
use App\Library\ElasticSearch\Builder\Document\DocumentBuilder;

class DeleteDocumentBuilder extends DocumentBuilder implements DeleteDocumentInterface
{
    private string $documentId;

    public function __construct($documentClass, string $documentId)
    {
        parent::__construct($documentClass);
        $this->documentId = $documentId;
    }

    public function exec()
    {
        $params = $this->getBaseParams();
        $params['id'] = $this->documentId;

        return $this->client->delete($params);
    }
}