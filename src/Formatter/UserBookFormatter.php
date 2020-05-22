<?php


namespace App\Formatter;


use App\Entity\User;
use App\Entity\UserBook;

class UserBookFormatter
{
    public static function format(UserBook $userBook): array
    {
        return [
            'id' => $userBook->getId(),
            'book' =>  BookFormatter::format($userBook->getBook()),
            'bookActions' => $userBook->getBookActionStatus(),
            'editionNumber' => $userBook->getEditionNumber(),
            'listIds' => $userBook->getListIds(),
            'note' => $userBook->getNote(),
            'tagIds' => $userBook->getTagIds(),
        ];
    }
}