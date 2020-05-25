<?php


namespace App\Formatter;


use App\Entity\User;
use App\Entity\UserBook;

class UserBookFormatter
{
    public static function format(UserBook $userBook): array
    {
        $bookLists = [];

        foreach ($userBook->getUserBookLists() as $userBookList)
        {
            $bookLists[] = UserBookListFormatter::format($userBookList);
        }

        return [
            'id' => $userBook->getId(),
            'book' =>  BookFormatter::format($userBook->getBook()),
            'bookActions' => $userBook->getBookActionStatus(),
            'editionNumber' => $userBook->getEditionNumber(),
            'bookLists' => $bookLists,
            'note' => $userBook->getNote()
        ];
    }
}