<?php


namespace App\Formatter;


use App\Entity\Book;
use App\Entity\UserBook;

class BookFormatter
{
    public static function format(Book $book): array
    {
        return [
            'id' => $book->getId(),
            'barcode' => $book->getBarcode(),
            'description' => $book->getDescription(),
            'editionNumber' => $book->getEditionNumber(),
            'language' => $book->getLanguage()->getName(),
            'pageNumber' => $book->getPageNumber(),
            'title' => $book->getTitle(),
            'volumeType' => $book->getVolumeType()
        ];
    }
}