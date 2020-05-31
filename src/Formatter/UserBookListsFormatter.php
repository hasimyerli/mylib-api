<?php


namespace App\Formatter;


class UserBookListsFormatter
{
    public static function format(array $userBookLists, int $userBookListsCount)
    {
        $data = [
            'total' => $userBookListsCount,
            'userBookLists' => []
        ];

        foreach ($userBookLists as $userBookList)
        {
            $data['userBookLists'][] = UserBookListFormatter::format($userBookList);
        }

        return $data;
    }
}