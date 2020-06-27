<?php


namespace App\Library\ElasticSearch\Builder\Document;



use App\Library\ElasticSearch\Event\Document\GetDocumentInterface;

class GetDocumentBuilder extends DocumentBuilder implements GetDocumentInterface
{
    private string $documentId;

    public function __construct($documentClass, string $documentId)
    {
        parent::__construct($documentClass);
        $this->documentId = $documentId;
    }

    public function get()
    {
        $params = $this->getBaseParams();
        $params['id'] = $this->documentId;

        return $this->client->get($params);
    }
}