<?php

namespace App\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * //alias and default parameters in the annotation are optional.
 * @ES\Index(alias="books", default=true)
 */
class BookDocument
{
    /**
     * @ES\Id()
     */
    public int $id;

    /**
     * @ES\Property(name="title", type="text", analyzer="NgramAnalyzer")
     */
    public string $title;

    /**
     * @ES\Property(name="description", type="text", analyzer="NgramAnalyzer")
     */
    public string $description;

    /**
     * @ES\Property(name="barcode", type="text")
     */
    public string $barcode;

    /**
     * @ES\Property(name="pageNumber", type="integer")
     */
    public int $pageNumber;

    /**
     * @ES\Property(name="language", type="object")
     */
    public array $language;

    /**
     * @ES\Property(name="editionNumber", type="text")
     */
    public string $editionNumber;

    /**
     * @ES\Property(name="authors", type="nested")
     */
    public array $authors;

    /**
     * @ES\Property(name="categories", type="nested")
     */
    public array $categories;

    /**
     * @ES\Property(name="publishers", type="nested")
     */
    public array $publishers;

    /**
     * @ES\Property(name="translators", type="nested")
     */
    public array $translators;

    /**
     * @ES\Property(name="status", type="integer")
     */
    public int $status;

    /**
     * @ES\Property(name="totalRateValue", type="float")
     */
    public float $totalRateValue;

    public function __construct(Array $properties=array()){
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * @return int
     */
    public function getLanguage(): array
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getEditionNumber(): string
    {
        return $this->editionNumber;
    }

    /**
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getPublishers(): array
    {
        return $this->publishers;
    }

    /**
     * @return array
     */
    public function getTranslators(): array
    {
        return $this->translators;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return float
     */
    public function getTotalRateValue(): float
    {
        return $this->totalRateValue;
    }

}