<?php

namespace App\Service\User;

use App\Constant\HttpStatusCode;
use App\Entity\User;
use App\Entity\UserBook;
use App\Repository\UserBookRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Service\Book\BookService;
use App\Util\ExceptionUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserBookService extends AbstractService
{
    private $bookService;

    public function __construct(EntityManagerInterface $em, BookService $bookService)
    {
        parent::__construct(UserBook::class, $em);
        $this->bookService = $bookService;
    }

    public function saveUserBook(User $user, UserBook $userBook, $bookId, $listIds, $tagIds)
    {
        $book = $this->bookService->getBook($bookId);
        $userBook->setUser($user);
        $userBook->setBook($book);
        $userBook->setListIds($listIds); // Todo: check listIds before add
        $userBook->setTagIds($tagIds); // // Todo: check tagIds before add
        $this->save($userBook);
    }

    protected function getRepository() : UserBookRepository
    {
        return parent::getRepository();
    }
}
