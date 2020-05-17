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
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends ApiAbstractController
{
    /**
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function signUp(Request $request, UserService $userService)
    {
        $user = new User();

        $form = $this->ValidForm(UserType::class, $user, $request);

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
