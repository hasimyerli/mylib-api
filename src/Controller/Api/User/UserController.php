<?php

namespace App\Controller\Api\User;

use App\Controller\Api\ApiAbstractController;
use App\Entity\User;
use App\Form\UserProfileUpdateType;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
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
        /**
         * @var User $user
         */
        if ($user = $this->getUser()) {
            //TODO:: array yerine DTO sınıfı yazılacak
            $userProfile = [
                'username' => $user->getUsername(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'mobilePhone' => $user->getMobilePhone(),
                'profileImageUrl' => $user->getProfileImageUrl(),
                'email' => $user->getEmail(),
                'isEmailConfirmed' => $user->getIsEmailConfirmed()
            ];
            return JsonSuccessResponse::build()
                ->setData($userProfile)
                ->getResponse();
        }

        return JsonFailureResponse::build()
            ->setMessage("Bilgileriniz doğrulanamadı. Lütfen tekrar deneyin!")
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
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $form = $this->validForm(UserProfileUpdateType::class, $user, $request);

        if ($form->isValid()) {
            $userService->saveUser($user);
            return JsonSuccessResponse::build()
                ->setMessage('Bilgileriniz güncellendi.')
                ->getResponse();
        }

        return JsonFailureResponse::build()
            ->setValidations($form->getValidations())
            ->getResponse();
    }
}
