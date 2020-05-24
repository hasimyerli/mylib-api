<?php

namespace App\Service\User;

use App\Entity\User;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Enum\Status;
use App\Repository\UserBookListRepository;
use App\Repository\UserBookRepository;
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
    private $bookService;
    private $translator;

    public function __construct(EntityManagerInterface $em, BookService $bookService, TranslatorInterface $translator)
    {
        parent::__construct(UserBookList::class, $em);
        $this->bookService = $bookService;
        $this->translator = $translator;
    }

    public function saveUserBookList(User $user, UserBookList $userBookList)
    {
        try {
            $userBookList->setUser($user);
            $this->save($userBookList);
            return $userBookList;
        }
        catch (UniqueConstraintViolationException $exception)
        {
            ExceptionUtil::throwException(JsonFailureResponse::build()
            ->setMessage($this->translator->trans('error.user_book.list.already_exists'))
            ->setStatusCode(Response::HTTP_CONFLICT));
        }
    }

    protected function getRepository() : UserBookListRepository
    {
        return parent::getRepository();
    }
}
