<?php


namespace App\Controller\Api\Book;
use App\Service\Book\RateService;
use App\Controller\Api\ApiAbstractController;
use App\Response\ApiResponse\JsonSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends ApiAbstractController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="return book's total rate.",
     * )
     * @SWG\Tag(name="Book")
     * @Security(name="Bearer")
     *
     * @param $bookId
     * @param RateService $rateService
     * @return JsonResponse
     */
    public function getRateByBookId($bookId, RateService $rateService) {
        $totalBookRate = $rateService->getRateByBookId($bookId);
        return JsonSuccessResponse::build()
            ->setData([
                'totalRate' => $totalBookRate
            ])
            ->getResponse();
    }
}