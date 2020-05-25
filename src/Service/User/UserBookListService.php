<?php

namespace App\Service\User;

use App\Entity\User;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Enum\Status;
use App\Repository\UserBookListRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Service\Book\BookService;
use App\Util\ExceptionUtil;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserBookListService extends AbstractService
{
    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        parent::__construct(UserBookList::class, $em);
        $this->translator = $translator;
    }

    public function saveUserBookList(User $user, UserBookList $userBookList)
    {
        try {
            $userBookList->setUser($user);
            $this->save($userBookList);
            return $userBookList;
        }
        catch (UniqueConstraintViolationException $error)
        {
            ExceptionUtil::throwException(JsonFailureResponse::build()
            ->setMessage($this->translator->trans('error.user_book.list.already_exists'))
            ->setStatusCode(Response::HTTP_CONFLICT));
        }
    }

    public function updateUserBookList(User $user, UserBookList $userBookList)
    {
        $this->saveUserBookList($user, $userBookList);
    }

    public function getUserBookList(User $user, int $userBookListId): UserBookList
    {
        $userBookList = $this->findOneBy([
            "id" => $userBookListId,
            "user" => $user
        ]);

        if(!$userBookList)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.user_book.list.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return $userBookList;
    }

    protected function getRepository(): UserBookListRepository
    {
        return parent::getRepository();
    }
}
