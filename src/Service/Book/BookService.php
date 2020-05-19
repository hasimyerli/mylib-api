<?php


namespace App\Service\Book;


use App\Constant\HttpStatusCode;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Response\ApiResponse\JsonFailureResponse;
use App\Service\AbstractService;
use App\Util\ExceptionUtil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class BookService extends AbstractService
{
    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        parent::__construct(Book::class, $em);
        $this->translator = $translator;
    }

    public function getBook($bookId)
    {
        $book = $this->find($bookId);

        if(!$book)
        {
            ExceptionUtil::throwException(
                JsonFailureResponse::build()
                    ->setMessage($this->translator->trans('error.book.not_found'))
                    ->setStatusCode(HttpStatusCode::NOT_FOUND)
            );
        }

        return $book;
    }

    protected function getRepository() : BookRepository
    {
        return parent::getRepository();
    }
}