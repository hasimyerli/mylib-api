<?php


namespace App\Service\Book;


use App\Entity\Book;
use App\Model\BookFilterModel;
use App\Repository\BookRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Util\ExceptionUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookService extends AbstractService
{
    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        parent::__construct(Book::class, $em);
        $this->translator = $translator;
    }

    public function getBook($bookId):Book
    {
        $book = $this->find($bookId);

        if(!$book)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.book.not_found'))
                    ->setStatusCode(Response::HTTP_NOT_FOUND)
            );
        }

        return $book;
    }

    public function getBooks(BookFilterModel $bookFilterModel): \stdClass
    {
        return $this->getRepository()->getBooks($bookFilterModel);
    }

    protected function getRepository() : BookRepository
    {
        return parent::getRepository();
    }
}