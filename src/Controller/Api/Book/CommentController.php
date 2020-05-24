<?php


namespace App\Controller\Api\Book;
use App\Formatter\CommentsFormatter;
use App\Service\Book\CommentService;
use App\Controller\Api\ApiAbstractController;
use App\Response\ApiResponse\JsonSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @SWG\Tag(name="Book")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param CommentService $commentService
     * @return JsonResponse
     */
    public function getCommentsByBookId($bookId, CommentService $commentService)
    {
        $comments = $commentService->getCommentsByBookId($bookId);
        dd($comments);
        return JsonSuccessResponse::build()
            ->getResponse();
    }
}