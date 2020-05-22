<?php


namespace App\Formatter;


use App\Entity\User;

class UserProfileFormatter
{
    public static function format(User $userProfile): array
    {
        return [
            'username' => $userProfile->getUsername(),
            'firstName' => $userProfile->getFirstName(),
            'lastName' => $userProfile->getLastName(),
            'mobilePhone' => $userProfile->getMobilePhone(),
            'email' => $userProfile->getEmail()
        ];
    }
}