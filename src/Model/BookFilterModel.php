<?php


namespace App\Model;


class BookFilterModel extends BaseFilterModel
{
    private array $authorIds = [];
    private ?string $barcode = '';
    private array $categoryIds = [];
    private array $languageIds = [];
    private array $publisherIds = [];
    private array $rateValues = [];
    private array $translatorIds = [];

    /**
     * @return array
     */
    public function getAuthorIds(): array
    {
        return $this->authorIds;
    }

    /**
     * @param array $authorIds
     */
    public function setAuthorIds(array $authorIds): void
    {
        $this->authorIds = $authorIds;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return array
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @param array $categoryIds
     */
    public function setCategoryIds(array $categoryIds): void
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @return array
     */
    public function getLanguageIds(): array
    {
        return $this->languageIds;
    }

    /**
     * @param array $languageIds
     */
    public function setLanguageIds(array $languageIds): void
    {
        $this->languageIds = $languageIds;
    }

    /**
     * @return array
     */
    public function getPublisherIds(): array
    {
        return $this->publisherIds;
    }

    /**
     * @param array $publisherIds
     */
    public function setPublisherIds(array $publisherIds): void
    {
        $this->publisherIds = $publisherIds;
    }

    /**
     * @return array
     */
    public function getRateValues(): array
    {
        return $this->rateValues;
    }

    /**
     * @param array $rateValues
     */
    public function setRateValues(array $rateValues): void
    {
        $this->rateValues = $rateValues;
    }

    /**
     * @return array
     */
    public function getTranslatorIds(): array
    {
        return $this->translatorIds;
    }

    /**
     * @param array $translatorIds
     */
    public function setTranslatorIds(array $translatorIds): void
    {
        $this->translatorIds = $translatorIds;
    }


}