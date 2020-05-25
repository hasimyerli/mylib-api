<?php


namespace App\Service\Book;


use App\Entity\Book;
use App\Entity\Comment;
use App\Entity\User;
use App\Enum\Status;
use App\Repository\CommentRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Util\ExceptionUtil;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @param $bookId
     * @return Comment[]|Collection
     */
    public function getCommentsByBookId($bookId)
    {
        return $this->bookService->getBook($bookId)->getComments();
        //TODO::...
    }

    /**
     * @param $user
     * @param $bookId
     * @param Comment $comment
     * @param null $parentId
     */
    public function createComment($user, $bookId, Comment $comment, $parentId = null)
    {
        $book = $this->bookService->getBook($bookId);
        $parentComment = $this->getRepository()->findOneBy([
            'id' => $parentId,
            'book' => $book
        ]);
        $comment->setBook($book);
        $comment->setUser($user);
        $comment->setParent($parentComment);
        $comment->setStatus(Status::ACTIVE);
        $comment->setApprovalStatus(1);

        $this->save($comment);
    }

    /**
     * @param User $user
     * @param $bookId
     * @param $commentId
     * @return Comment
     */
    public function getCommentByUser(User $user, $bookId, $commentId): Comment
    {
        $comment = $this->getRepository()->findOneBy([
            'id' => $commentId,
            'user' => $user,
            'book' => $this->bookService->getBook($bookId)
        ]);

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

    /**
     * @param User $user
     * @param $bookId
     * @param $commentId
     */
    public function deleteComment(User $user, $bookId, $commentId)
    {
        $comment = $this->getCommentByUser($user, $bookId, $commentId);
        $isDeleted = $this->getRepository()->deleteCommentAndChildComments($comment);
        if (!$isDeleted) {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.comment.already_deleted'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }
    }

    protected function getRepository(): CommentRepository
    {
        return parent::getRepository();
    }
}