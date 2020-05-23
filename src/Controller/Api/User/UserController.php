<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Form\UserProfileUpdateType;
use App\Formatter\UserProfileFormetter;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Service\User\UserService;
use App\Util\ExceptionUtil;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="return user profile info",
     * )
     * @SWG\Tag(name="Auth")
     * @Security(name="Bearer")
     *
     * @param UserService $userService
     * @return JsonResponse
     */
    public function getProfile(UserService $userService)
    {
        if (!$user = $this->getUser()) {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->getTranslator()->trans('error.user.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return JsonSuccessResponse::build()
            ->setData(UserProfileFormetter::format($user))
            ->getResponse();
    }

    /**
    /**
     * @SWG\Response(
     *     response=200,
     *     description="User profile update",
     * )
     * @SWG\Parameter(
     *     name="User body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="firstName", type="string"),
     *         @SWG\Property(property="lastName", type="string"),
     *         @SWG\Property(property="mobilePhone", type="string"),
     *         @SWG\Property(property="password", type="string"),
     *         @SWG\Property(property="profileImage", type="string")
     *     )
     * )
     * @SWG\Tag(name="Auth")
     * @Security(name="Bearer")

     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function updateProfile(Request $request, UserService $userService)
    {
        $user = $this->getUser();
        $this->validateForm(UserProfileUpdateType::class, $user, $request);
        $userService->saveUser($user);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.user.info_updated'))
            ->getResponse();
    }
}
