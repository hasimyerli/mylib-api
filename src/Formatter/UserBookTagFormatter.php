<?php


namespace App\Formatter;

use App\Entity\UserBookTag;

class UserBookTagFormatter
{
    public static function format(UserBookTag $userBookTag): array
    {
        return [
            'id' => $userBookTag->getId(),
            'name' =>  $userBookTag->getName(),
            'color' => $userBookTag->getColor(),
        ];
    }
}