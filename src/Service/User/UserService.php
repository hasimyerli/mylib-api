<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService extends AbstractService
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct(User::class, $em);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function saveUser(User $user)
    {
        //TODO: $user->getProfileImage(); s3 upload
        $profileImageUrl = "";
        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());

        // TODO: Şifre güncellenmiş ise jwt date expired
        if ($user->getPassword() && $user->getPassword() != $password) {
            // ...
        }

        $user->setPassword($password);
        $user->setProfileImageUrl($profileImageUrl);
        $this->save($user);
    }

    protected function getRepository():UserRepository
    {
        return parent::getRepository();
    }
}
