<?php


namespace App\Formatter;


use App\Entity\User;

class UserProfileFormetter
{
    public static function format(User $user)
    {
        return [
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'mobilePhone' => $user->getMobilePhone(),
            'profileImageUrl' => $user->getProfileImageUrl(),
            'email' => $user->getEmail(),
            'isEmailConfirmed' => $user->getIsEmailConfirmed()
        ];
    }
}