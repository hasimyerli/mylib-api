<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\UserBook;
use App\Form\UserBookType\UserBookType;
use App\Formatter\UserBookFormatter;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Form\UserBookType\SaveUserBookType;
use App\Service\User\UserBookService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserBookController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Creates user book",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer TOKEN",
     *     description="Authorization" )
     * @SWG\Parameter(
     *     name="User body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="note", type="string"),
     *         @SWG\Property(
     *                  property="editionNumber",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *        @SWG\Property(
     *                  property="listIds",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *        @SWG\Property(
     *                  property="tagIds",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *
     *     )
     * )
     * @SWG\Tag(name="User/Book")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function saveUserBook(Request $request, UserBookService $userBookService)
    {
        $userBook = new UserBook();
        $this->validateForm(SaveUserBookType::class, $userBook, $request,$requestParams);

        [
            'bookId' => $bookId,
            'listIds' => $listIds,
            'tagIds' => $tagIds
        ] = $requestParams;

        $newUserBook = $userBookService->saveUserBook($this->getUser(), $userBook, $bookId, $listIds, $tagIds);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.added_into_library'))
            ->setData(UserBookFormatter::format($newUserBook))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Updates user book",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer TOKEN",
     *     description="Authorization" )
     * @SWG\Parameter(
     *     name="userBookId",
     *     in="path",
     *     type="number",
     *     required=true )
     * @SWG\Parameter(
     *     name="User body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="note", type="string"),
     *         @SWG\Property(
     *                  property="editionNumber",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *        @SWG\Property(
     *                  property="listIds",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *        @SWG\Property(
     *                  property="tagIds",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="number"
     *                  ),
     *              ),
     *
     *     )
     * )
     * @SWG\Tag(name="User/Book")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function updateUserBook(Request $request, UserBookService $userBookService)
    {
        $userBookId = $request->get('userBookId');
        $userBook = $userBookService->getUserBook($this->getUser(), $userBookId);

        $this->validateForm(UserBookType::class, $userBook, $request,$requestParams);

        [
            'listIds' => $listIds,
            'tagIds' => $tagIds
        ] = $requestParams;

        $updatedUserBook = $userBookService->updateUserBook($this->getUser(), $userBook, $listIds, $tagIds);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.info_updated'))
            ->setData(UserBookFormatter::format($updatedUserBook))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Deletes user book",
     * )
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer TOKEN",
     *     description="Authorization" )
     * @SWG\Parameter(
     *     name="userBookId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Tag(name="User/Book")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function deleteUserBook(Request $request, UserBookService $userBookService)
    {
        $userBookId = $request->get('userBookId');
        $userBookService->deleteUserBook($this->getUser(), $userBookId);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.deleted_from_library'))
            ->getResponse();
    }
}
