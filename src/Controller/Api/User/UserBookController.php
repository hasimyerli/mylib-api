<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\UserBook;
use App\Form\UserBookType\UserBookType;
use App\Formatter\UserBookFormatter;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Form\UserBookType\SaveUserBookType;
use App\Service\User\UserBookService;
use App\Service\User\UserBookTagService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserBookController extends ApiAbstractController
{
    /**
     * @SWG\Response(response=200, description="Creates user book")
     * @SWG\Parameter(name="body", in="body", type="string", required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="bookId", type="number"),
     *         @SWG\Property(property="note", type="string"),
     *         @SWG\Property(property="editionNumber", type="array", @SWG\Items(type="number")),
     *         @SWG\Property(property="bookListIds", type="array", @SWG\Items(type="number")),
     *         @SWG\Property(property="bookTagIds", type="array", @SWG\Items(type="number")),
     *     )
     * )
     *
     * @SWG\Tag(name="User/Books")
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
            'bookListIds' => $userBookListIds,
            'bookTagIds' => $userBookTagIds
        ] = $requestParams;

        $newUserBook = $userBookService->saveUserBook($this->getUser(), $userBook, $bookId, $userBookListIds, $userBookTagIds);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.added_into_library'))
            ->setData(UserBookFormatter::format($newUserBook))
            ->getResponse();
    }

    /**
     * @SWG\Response(response=200, description="Updates user book")
     * @SWG\Parameter(name="userBookId", in="path", type="number",required=true )
     * @SWG\Parameter(name="body", in="body", type="string",required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="note", type="string"),
     *         @SWG\Property(property="editionNumber", type="array", @SWG\Items(type="number")),
     *         @SWG\Property(property="bookListIds", type="array", @SWG\Items(type="number")),
     *         @SWG\Property(property="bookListTagIds", type="array", @SWG\Items(type="number"))
     *     )
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function updateUserBook($userBookId, Request $request, UserBookService $userBookService)
    {
        $userBook = $userBookService->getUserBook($this->getUser(), $userBookId);

        $this->validateForm(UserBookType::class, $userBook, $request,$requestParams);

        [
            'bookListIds' => $userBookListIds,
            'bookTagIds' => $userBookTagIds
        ] = $requestParams;

        $updatedUserBook = $userBookService->updateUserBook($this->getUser(), $userBook, $userBookListIds, $userBookTagIds);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.info_updated'))
            ->setData(UserBookFormatter::format($updatedUserBook))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Gets user book",
     * )
     * @SWG\Parameter(
     *     name="userBookId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function getUserBook($userBookId, Request $request, UserBookService $userBookService)
    {
        $userBook = $userBookService->getUserBook($this->getUser(), $userBookId);

        return JsonSuccessResponse::build()
            ->setData(UserBookFormatter::format($userBook))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Deletes user book",
     * )
     * @SWG\Parameter(
     *     name="userBookId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Tag(name="User/Books")
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

    /**
     * @SWG\Response(
     *     response=200,
     *     description="add books to user book tag"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="userBookIds", type="array", @SWG\Items(type="number")),
     *     )
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookTagId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function createBooksToUserBookTag($userBookTagId, Request $request, UserBookService $userBookService)
    {
        $requestParams = json_decode($request->getContent(), true);
        $userBookService->createBooksToUserBookTag($this->getUser(), $userBookTagId, $requestParams['userBookIds']);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.added_into_tag_list'))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="add books to user book tag"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="userBookIds", type="array", @SWG\Items(type="number")),
     *     )
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookTagId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function deleteBooksFromUserBookTag($userBookTagId, Request $request, UserBookService $userBookService)
    {
        $requestParams = json_decode($request->getContent(), true);
        $userBookService->deleteBooksFromUserBookTag($this->getUser(), $userBookTagId, $requestParams['userBookIds']);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.delete_from_tag_list'))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="add books to user book list"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="userBookIds", type="array", @SWG\Items(type="number")),
     *     )
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookListId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function createBooksToUserBookList($userBookListId, Request $request, UserBookService $userBookService)
    {
        $requestParams = json_decode($request->getContent(), true);
        $userBookService->createBooksToUserBookList($this->getUser(), $userBookListId, $requestParams['userBookIds']);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.added_into_list'))
            ->getResponse();
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="add books to user book list"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="userBookIds", type="array", @SWG\Items(type="number")),
     *     )
     * )
     * @SWG\Tag(name="User/Books")
     *
     * @param $userBookListId
     * @param Request $request
     * @param UserBookService $userBookService
     * @return JsonResponse
     */
    public function deleteBooksFromUserBookList($userBookListId, Request $request, UserBookService $userBookService)
    {
        $requestParams = json_decode($request->getContent(), true);
        $userBookService->deleteBooksFromUserBookList($this->getUser(), $userBookListId, $requestParams['userBookIds']);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.delete_from_list'))
            ->getResponse();
    }
}
