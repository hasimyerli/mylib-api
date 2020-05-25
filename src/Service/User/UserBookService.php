<?php

namespace App\Service\User;

use App\Entity\User;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Enum\Status;
use App\Repository\UserBookRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Service\Book\BookService;
use App\Util\ExceptionUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserBookService extends AbstractService
{
    private $bookService;
    private $translator;
    private $userBookListService;

    public function __construct(EntityManagerInterface $em, BookService $bookService, UserBookListService $userBookListService, TranslatorInterface $translator)
    {
        parent::__construct(UserBook::class, $em);
        $this->bookService = $bookService;
        $this->userBookListService = $userBookListService;
        $this->translator = $translator;
    }

    public function saveUserBook(User $user, UserBook $userBook, $bookId, $userBookListIds, $tagIds)
    {
        $book = $this->bookService->getBook($bookId);
        $userBook->setBook($book);
        return $this->updateUserBook($user, $userBook,$userBookListIds, $tagIds);
    }

    public function updateUserBook(User $user, UserBook $userBook, $userBookListIds, $tagIds)
    {
        $userBook->setUser($user);

        foreach ($userBookListIds as $userBookListId)
        {
            $userBookList = $this->userBookListService->getUserBookList($user, $userBookListId);
            $userBook->addUserBookList($userBookList);
        }

        $this->save($userBook);
        return $userBook;
    }

    public function getUserBook(User $user, int $userBookId): UserBook
    {
        $userBook = $this->getRepository()->findOneBy([
            "id" => $userBookId,
            "user" => $user,
            "status" => Status::ACTIVE
        ]);

        if(!$userBook)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.user_book.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return $userBook;
    }

    public function deleteUserBook(User $user, int $userBookId)
    {
        $userBook = $this->getUserBook($user, $userBookId);
        $userBook->setStatus(Status::DELETED);
        $this->save($userBook);
    }

    protected function getRepository() : UserBookRepository
    {
        return parent::getRepository();
    }
}
