<?php


namespace App\Formatter;


use App\Document\BookDocument;
use App\Entity\Book;
use App\Entity\UserBook;

class BookFormatter
{
    public static function format(BookDocument $book): array
    {
        return [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'barcode' => $book->getBarcode(),
            'editionNumber' => $book->getEditionNumber(),
            'authors' => $book->getAuthors(),
            'publishers' => $book->getPublishers(),
            'translators' => $book->getTranslators(),
            'totalRateValue' => $book->getTotalRateValue(),
            'categories' => $book->getCategories(),
            'language' => $book->getLanguage(),
            'pageNumber' => $book->getPageNumber(),
            'description' => $book->getDescription()
        ];
    }
}