<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\UserBook;
use App\Entity\UserBookList;
use App\Form\GetUserBookListsType;
use App\Form\GetUserBookTagsType;
use App\Form\UserBookListType\UserBookListType;
use App\Form\UserBookType\UserBookType;
use App\Formatter\UserBookFormatter;
use App\Formatter\UserBookListFormatter;
use App\Formatter\UserBookListsFormatter;
use App\Formatter\UserBookTagsFormatter;
use App\Model\BaseFilterModel;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Form\UserBookType\SaveUserBookType;
use App\Service\User\UserBookListService;
use App\Service\User\UserBookService;
use App\Service\User\UserBookTagService;
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
        $userBookList = $userBookListService->updateUserBookList($this->getUser(), $userBookList);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.list.name_updated'))
            ->setData(UserBookListFormatter::format($userBookList))
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

    /**
     * @SWG\Response(response=200, description="Deletes user book tag")
     * @SWG\Parameter(name="page", in="query", type="number", required=true, default=1)
     * @SWG\Parameter(name="searchText", in="query", type="string", required=false)
     * @SWG\Parameter(name="sort", in="query", type="string", required=true, default="name", enum={"id", "name"})
     * @SWG\Parameter(name="order", in="query", type="string", required=true, default="desc", enum={"desc", "asc"})
     * @SWG\Tag(name="User/Book/Lists")
     *
     * @param Request $request
     * @param UserBookListService $userBookListService
     * @return JsonResponse
     */
    public function getUserBookLists(Request $request, UserBookListService $userBookListService)
    {
        $filterModel = new BaseFilterModel();
        $this->validateForm(GetUserBookListsType::class, $filterModel, $request);
        $userBookLists = $userBookListService->getUserBookLists($this->getUser(), $filterModel);
        $userBookListsCount = $userBookListService->getUserBookListsCount($this->getUser(), $filterModel);

        return JsonSuccessResponse::build()
            ->setData(UserBookListsFormatter::format($userBookLists, $userBookListsCount))
            ->getResponse();
    }
}
