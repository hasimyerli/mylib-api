<?php

namespace App\Service\User;

use App\Entity\User;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Entity\UserBookTag;
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
    private $userBookTagService;

    public function __construct(EntityManagerInterface $em,
                                BookService $bookService,
                                UserBookListService $userBookListService,
                                UserBookTagService $userBookTagService,
                                TranslatorInterface $translator)
    {
        parent::__construct(UserBook::class, $em);
        $this->bookService = $bookService;
        $this->userBookListService = $userBookListService;
        $this->userBookTagService = $userBookTagService;
        $this->translator = $translator;
    }

    public function saveUserBook(User $user, UserBook $userBook, $bookId, $userBookListIds, $userBookTagIds)
    {
        $book = $this->bookService->getBook($bookId);
        $userBook->setBook($book);
        return $this->updateUserBook($user, $userBook,$userBookListIds, $userBookTagIds);
    }

    public function updateUserBook(User $user, UserBook $userBook, $userBookListIds, $userBookTagIds)
    {
        $userBook->setUser($user);

        $userBook->removeAllUserBookLists();

        foreach ($userBookListIds as $userBookListId)
        {
            $userBookList = $this->userBookListService->getUserBookList($user, $userBookListId);
            $userBook->addUserBookList($userBookList);
        }

        $userBook->removeAllUserBookTags();

        foreach ($userBookTagIds as $userBookTagId)
        {
            $userBookTag = $this->userBookTagService->getUserBookTag($user, $userBookTagId);
            $userBook->addUserBookTag($userBookTag);
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

    public function createBooksToUserBookTag(User $user, int $userBookTagId, array $userBookIds)
    {
        $userBookTag = $this->userBookTagService->getUserBookTag($user, $userBookTagId);
        $userBooks = $this->findBy([
            'id' => $userBookIds,
            'user' => $user,
            'status' => Status::ACTIVE
        ]);

        $this->checkBulkInsertAndDeleteUserBookFromUserBookTag($userBooks, $userBookIds);

        $count = 1;
        /**
         * @var UserBook $userBook
         */
        foreach ($userBooks as $userBook) {
            $userBookTag->addUserBook($userBook);
            if ($this->isBulkInsertAndDeleteUserBookFromUserBookTag($userBooks, $count) || (count($userBooks) == $count)) {
                $this->save($userBookTag);
            }
            $count++;
        }
    }

    public function deleteBooksFromUserBookTag(User $user, int $userBookTagId, array $userBookIds)
    {
        $userBookTag = $this->userBookTagService->getUserBookTag($user, $userBookTagId);
        $userBooks = $this->findBy([
            'id' => $userBookIds,
            'user' => $user,
            'status' => Status::ACTIVE
        ]);

        $this->checkBulkInsertAndDeleteUserBookFromUserBookTag($userBooks, $userBookIds);

        $count = 1;
        /**
         * @var UserBook $userBook
         */
        foreach ($userBooks as $userBook) {
            $userBookTag->removeUserBook($userBook);
            if ($this->isBulkInsertAndDeleteUserBookFromUserBookTag($userBooks, $count) || (count($userBooks) == $count)) {
                $this->save($userBookTag);
            }
            $count++;
        }
    }

    private function checkBulkInsertAndDeleteUserBookFromUserBookTag($userBooks, $userBookIds)
    {
        $tempUserBookIds = [];

        /**
         * @var UserBook $userBook
         */
        foreach ($userBooks as $userBook) {
            $tempUserBookIds[] = $userBook->getId();
        }

        foreach ($userBookIds as $userBookId) {
            if (!in_array($userBookId, $tempUserBookIds)) {
                ExceptionUtil::throwException(
                    JsonFailureResponse::build()
                        ->setMessage($this->translator->trans('error.user_book.not_found_from_library'))
                        ->setInternalMessage(sprintf($this->translator->trans('error.user_book.internal_not_found_from_library'), $userBookId))
                        ->setStatusCode(Response::HTTP_NOT_FOUND)
                );
            }
        }
    }

    private function isBulkInsertAndDeleteUserBookFromUserBookTag(array $data, int $count)
    {
        return (count($data) >= 100 && ($count % 100) == 0);
    }

    protected function getRepository() : UserBookRepository
    {
        return parent::getRepository();
    }
}
