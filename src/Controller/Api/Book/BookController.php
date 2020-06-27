<?php


namespace App\Controller\Api\Book;


use App\Controller\Api\ApiAbstractController;
use App\Document\BookDocument;
use App\Form\BookListType;
use App\Formatter\BooksFormatter;
use App\Formatter\UserBookTagsFormatter;
use App\Model\BaseFilterModel;
use App\Model\BookFilterModel;
use App\Response\ApiResponse\JsonSuccessResponse;
use App\Service\Book\BookService;
use App\Service\User\UserBookTagService;
use Elasticsearch\ClientBuilder;
use ONGR\App\Document\DummyDocument;
use ONGR\ElasticsearchBundle\ONGRElasticsearchBundle;
use ONGR\ElasticsearchBundle\Service\GenerateService;
use ONGR\ElasticsearchBundle\Service\IndexService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends ApiAbstractController
{

    /**
     * @SWG\Response(response=200, description="get books")
     * @SWG\Parameter(name="page", in="query", type="number", required=true, default=1)
     * @SWG\Parameter(name="searchText", in="query", type="string", required=false)
     * @SWG\Parameter(name="sort", in="query", type="string", required=true, default="name", enum={"id", "name"})
     * @SWG\Parameter(name="order", in="query", type="string", required=true, default="desc", enum={"desc", "asc"})
     * @SWG\Parameter(name="authorIds", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Parameter(name="barcode", in="query", type="string", required=false)
     * @SWG\Parameter(name="categoryIds", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Parameter(name="languageIds", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Parameter(name="publisherIds", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Parameter(name="rateValues", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Parameter(name="translatorIds", in="query", type="array", required=false, @SWG\Items(type="number"))
     * @SWG\Tag(name="Book")
     *
     * @param Request $request
     * @param BookService $bookService
     * @return JsonResponse
     */
    public function getBooks(Request $request, BookService $bookService)
    {
        $bookFilterModel = new BookFilterModel();
        $this->validateForm(BookListType::class, $bookFilterModel, $request);

        $booksResult = $bookService->getBooks($bookFilterModel);

        return JsonSuccessResponse::build()
            ->setData(BooksFormatter::format($booksResult))
            ->getResponse();
    }
}