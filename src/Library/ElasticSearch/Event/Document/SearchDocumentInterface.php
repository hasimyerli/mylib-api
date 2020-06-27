<?php


namespace App\Library\ElasticSearch\Event\Document;


interface SearchDocumentInterface
{
    public function addQueryMatch($field, $value): SearchDocumentInterface;
    public function setSize(int $size): SearchDocumentInterface;
    public function setSort($field, $order): SearchDocumentInterface;
    public function get();
}