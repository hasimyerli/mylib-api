<?php


namespace App\Formatter;


use App\Entity\Book;

class BooksFormatter
{
    public static function format(\stdClass $booksResult): array
    {
        $data = [
            'total' => $booksResult->total,
            'books' => []
        ];


        foreach ($booksResult->results as $book)
        {
            $data['books'][] = BookFormatter::format($book);
        }

        return $data;
    }
}