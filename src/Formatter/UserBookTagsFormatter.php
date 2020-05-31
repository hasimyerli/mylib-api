<?php


namespace App\Formatter;


use App\Entity\UserBookTag;
use Doctrine\Common\Collections\Collection;

class UserBookTagsFormatter
{

    public static function format(array $userBookTags, int $userBookTagsCount)
    {
        $data = [
            'total' => $userBookTagsCount,
            'userBookTags' => []
        ];

        foreach ($userBookTags as $userBookTag)
        {
            $data['userBookTags'][] = UserBookTagFormatter::format($userBookTag);
        }

        return $data;
    }
}