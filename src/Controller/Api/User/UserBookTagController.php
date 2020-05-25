<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\UserBook;
use App\Entity\UserBookTag;
use App\Form\UserBookTagType;
use App\Form\UserBookType\UserBookType;
use App\Formatter\UserBookFormatter;
use App\Formatter\UserBookListFormatter;
use App\Formatter\UserBookTagFormatter;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Form\UserBookType\SaveUserBookType;
use App\Service\User\UserBookService;
use App\Service\User\UserBookTagService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class UserBookTagController extends ApiAbstractController
{
    /**
     * @SWG\Response(response=200, description="Creates user book tag")
     * @SWG\Parameter(name="body", in="body", type="string", required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="color", type="string"),
     *     )
     * )
     *
     * @SWG\Tag(name="User/Book/Tags")
     *
     * @param Request $request
     * @param UserBookTagService $userBookTagService
     * @return JsonResponse
     */
    public function saveUserBookTag(Request $request, UserBookTagService $userBookTagService)
    {
        $userBookTag = new UserBookTag();
        $this->validateForm(UserBookTagType::class, $userBookTag, $request);
        $userBookTag = $userBookTagService->saveUserBookTag($this->getUser(), $userBookTag);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.tag.added'))
            ->setData(UserBookTagFormatter::format($userBookTag))
            ->getResponse();
    }

    /**
     * @SWG\Response(response=200, description="Updates user book tag")
     * @SWG\Parameter(
     *     name="userBookTagId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Parameter(name="body", in="body", type="string", required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string"),
     *         @SWG\Property(property="color", type="string"),
     *     )
     * )
     * @SWG\Tag(name="User/Book/Tags")
     *
     * @param $userBookTagId
     * @param Request $request
     * @param UserBookTagService $userBookTagService
     * @return JsonResponse
     */
    public function updateUserBookTag($userBookTagId, Request $request, UserBookTagService $userBookTagService)
    {
        $newUserBookTag = new UserBookTag();
        $this->validateForm(UserBookTagType::class, $newUserBookTag, $request);

        $userBookTag = $userBookTagService->getUserBookTag($this->getUser(), $userBookTagId);

        $userBookTag->setName($newUserBookTag->getName());
        $userBookTag->setColor($newUserBookTag->getColor());

        $userBookTag = $userBookTagService->updateUserBookTag($this->getUser(), $userBookTag);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.tag.name_updated'))
            ->setData(UserBookTagFormatter::format($userBookTag))
            ->getResponse();
    }

    /**
     * @SWG\Response(response=200, description="Deletes user book tag")
     * @SWG\Parameter(
     *     name="userBookTagId",
     *     in="path",
     *     type="number",
     *     required=true,
     * )
     * @SWG\Tag(name="User/Book/Tags")
     *
     * @param $userBookTagId
     * @param Request $request
     * @param UserBookTagService $userBookTagService
     * @return JsonResponse
     */
    public function deleteUserBookTag($userBookTagId, Request $request, UserBookTagService $userBookTagService)
    {
        $userBookTagService->deleteUserBookTag($this->getUser(), $userBookTagId);

        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user_book.tag.deleted'))
            ->getResponse();
    }

}
