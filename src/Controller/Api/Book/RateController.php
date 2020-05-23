<?php


namespace App\Controller\Api\Book;
use App\Form\RateSaveType;
use App\Service\Book\RateService;
use App\Controller\Api\ApiAbstractController;
use App\Response\ApiResponse\JsonSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="update book's rate.",
     * )
     * @SWG\Parameter(
     *     name="User body",
     *     in="body",
     *     type="string",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="value", type="integer"),
     *     )
     * )
     * @SWG\Tag(name="Book")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param RateService $rateService
     * @param Request $request
     * @return JsonResponse
     */
    public function upsertRate($bookId, Request $request, RateService $rateService)
    {
        $user = $this->getUser();
        $this->validateForm(RateSaveType::class, null, $request, $requestParams);
        $rateService->upsertRate($user, $bookId, $requestParams['value']);
        return JsonSuccessResponse::build()
            ->setMessage($this->getTranslator()->trans('success.rate.added_rate'))
            ->getResponse();
    }
}