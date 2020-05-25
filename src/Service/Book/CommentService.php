<?php


namespace App\Service\Book;


use App\Entity\Comment;
use App\Enum\Status;
use App\Repository\CommentRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Util\ExceptionUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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

    public function getComment($id): Comment
    {
        $comment = $this->getRepository()->find($id);

        if(!$comment)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.comment.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return $comment;
    }

    public function createComment($user, $bookId, Comment $comment, $parentId = null)
    {
        $book = $this->bookService->getBook($bookId);
        $parentComment = $parentId ? $this->getComment($parentId) : null;

        $comment->setBook($book);
        $comment->setUser($user);
        $comment->setParent($parentComment);
        $comment->setStatus(Status::ACTIVE);
        $comment->setApprovalStatus(1);

        $this->save($comment);
    }

    protected function getRepository(): CommentRepository
    {
        return parent::getRepository();
    }
}