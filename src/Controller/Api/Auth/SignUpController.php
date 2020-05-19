<?php

namespace App\Controller\Api\Auth;

use App\Controller\Api\ApiAbstractController;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Entity\User;
use App\Form\UserType;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="User sign-up",
     * )
     * @SWG\Parameter(
     *     name="User body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="username", type="string"),
     *         @SWG\Property(property="password", type="string"),
     *         @SWG\Property(property="email", type="string"),
     *         @SWG\Property(property="firstName", type="string"),
     *         @SWG\Property(property="lastName", type="string"),
     *         @SWG\Property(property="mobilePhone", type="string"),
     *         @SWG\Property(property="profileImage", type="string")
     *     )
     * )
     * @SWG\Tag(name="Auth")
     * @Security(name="Bearer")
     *
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function signUp(Request $request, UserService $userService)
    {
        $user = new User();
        $form = $this->validForm(UserType::class, $user, $request);

        if ($form->isValid()) {
            $userService->saveUser($user);
            return JsonSuccessResponse::build()
                ->getResponse();
        }

        return JsonFailureResponse::build()
            ->setValidations($form->getValidations())
            ->getResponse();
    }
}
