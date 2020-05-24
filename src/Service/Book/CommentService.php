<?php


namespace App\Service\Book;


use App\Entity\Comment;
use App\Enum\Status;
use App\Repository\CommentRepository;
use App\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CommentService extends AbstractService
{
    private $bookService;
    private $translator;

    public function __construct(EntityManagerInterface $em, BookService $bookService, TranslatorInterface $translator)
    {
        parent::__construct(Comment::class, $em);
        $this->bookService = $bookService;
        $this->translator = $translator;
    }

    public function getCommentsByBookId($bookId)
    {
        return $this->bookService->getBook($bookId)->getComments();
      //TODO::...
    }

    protected function getRepository(): CommentRepository
    {
        return parent::getRepository();
    }
}