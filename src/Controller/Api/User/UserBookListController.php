<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Form\UserBookListType\UserBookListType;
use App\Form\UserBookType\UserBookType;
use App\Formatter\UserBookFormatter;
use App\Formatter\UserBookListFormatter;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Form\UserBookType\SaveUserBookType;
use App\Service\User\UserBookListService;
use App\Service\User\UserBookService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserBookListController extends ApiAbstractController
{
    /**
     * @SWG\Response(response=200, description="Creates user book list")
     * @SWG\Parameter(name="body", in="body", type="string", required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="User/Book/Lists")
     *
     * @param Request $request
     * @param UserBookListService $userBookListService
     * @return JsonResponse
     */
    public function saveUserBookList(Request $request, UserBookListService $userBookListService)
    {
        $userBookList = new UserBookList();
        $this->validateForm(UserBookListType::class, $userBookList, $request);
        $userBookList = $userBookListService->saveUserBookList($this->getUser(), $userBookList);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.list.added'))
            ->setData(UserBookListFormatter::format($userBookList))
            ->getResponse();
    }

    /**
     * @SWG\Response(response=200, description="Updates user book list")
     * @SWG\Parameter(
     *     name="userBookListId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Parameter(name="body", in="body", type="string", required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *     )
     * )
     * @SWG\Tag(name="User/Book/Lists")
     *
     * @param $userBookListId
     * @param Request $request
     * @param UserBookListService $userBookListService
     * @return JsonResponse
     */
    public function updateUserBookList($userBookListId, Request $request, UserBookListService $userBookListService)
    {
        $newUserBookList = new UserBookList();
        $this->validateForm(UserBookListType::class, $newUserBookList, $request);

        $userBookList = $userBookListService->getUserBookList($this->getUser(), $userBookListId);

        $userBookList->setName($newUserBookList->getName());
        $userBookListService->updateUserBookList($this->getUser(), $userBookList);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.list.name_updated'))
            ->getResponse();
    }

    /**
     * @SWG\Response(response=200, description="Deletes user book list")
     * @SWG\Parameter(
     *     name="userBookListId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Tag(name="User/Book/Lists")
     *
     * @param $userBookListId
     * @param Request $request
     * @param UserBookListService $userBookListService
     * @return JsonResponse
     */
    public function deleteUserBookList($userBookListId, Request $request, UserBookListService $userBookListService)
    {
        $userBookListService->deleteUserBookList($this->getUser(), $userBookListId);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.list.deleted'))
            ->getResponse();
    }

}
