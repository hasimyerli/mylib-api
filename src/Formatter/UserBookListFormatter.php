<?php


namespace App\Formatter;


use App\Entity\UserBookList;

class UserBookListFormatter
{
    public static function format(UserBookList $userBookList): array
    {
        return [
            'id' => $userBookList->getId(),
            'name' =>  $userBookList->getName()
        ];
    }
}