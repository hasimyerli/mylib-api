<?php


namespace App\Controller\Api\Book;
use App\Entity\Comment;
use App\Form\CommentType\CommentCreateType;
use App\Form\CommentType\CommentUpdateType;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Service\Book\CommentService;
use App\Controller\Api\ApiAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="return book's comments.",
     * )
     * @SWG\Tag(name="Book / Comment")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param CommentService $commentService
     */
    public function getCommentsByBookId($bookId, CommentService $commentService)
    {
        //TODO:...
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="create book comment",
     * )
     * @SWG\Parameter(
     *     name="Comment body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="text", type="string"),
     *     )
     * )
     * @SWG\Tag(name="Book / Comment")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param Request $request
     * @param CommentService $commentService
     * @return JsonResponse
     */
    public function createComment($bookId, Request $request, CommentService $commentService)
    {
        $comment = new Comment();

        $this->validateForm(CommentCreateType::class, $comment, $request, $requestParams);

        $parentId = isset($requestParams['parentId']) ?? null;

        $commentService->createComment($this->getUser(), $bookId, $comment, $parentId);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.comment.added'))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="update book comment",
     * )
     * @SWG\Parameter(
     *     name="Comment body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="text", type="string"),
     *     )
     * )
     * @SWG\Tag(name="Book / Comment")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param $commentId
     * @param Request $request
     * @param CommentService $commentService
     * @return JsonResponse
     */
    public function updateComment($bookId, $commentId, Request $request, CommentService $commentService)
    {
        $user = $this->getUser();
        $comment = $commentService->getCommentByUser($user, $bookId, $commentId);
        $this->validateForm(CommentUpdateType::class, $comment, $request);
        $commentService->updateComment($comment);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.comment.updated'))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="delete book comment",
     * )
     * @SWG\Tag(name="Book / Comment")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param $commentId
     * @param CommentService $commentService
     * @return JsonResponse
     */
    public function deleteComment($bookId, $commentId, CommentService $commentService)
    {
        $commentService->deleteComment($this->getUser(), $bookId, $commentId);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.comment.deleted'))
            ->getResponse();
    }
}