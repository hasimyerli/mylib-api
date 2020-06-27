<?php


namespace App\Library\ElasticSearch\Builder\Document;


use App\Library\ElasticSearch\Builder\Builder;
use ReflectionClass;

class DocumentBuilder extends Builder
{
    protected $documentClass;

    public function __construct($documentClass)
    {
        parent::__construct();
        $this->documentClass = $documentClass;
    }

    protected function getBaseParams(): array
    {
        return [
            'index' => $this->getIndexName()
        ];
    }

    private function getIndexName()
    {
        try {
            $reflection = new ReflectionClass($this->documentClass);
            $doc = $reflection->getDocComment();
            preg_match_all('#@(.*?)\n#s', $doc, $annotations);
            preg_match('/\balias\s*=\s*"(\d{5})"/', $annotations[0][0], $index);
        }
        catch (\ReflectionException $e) {
            throw new \Error('No index definition for document class');
        }
    }
}