<?php

namespace App\Repository;

use App\Constant\ElasticSearchConstant;
use App\Document\BookDocument;
use App\Entity\Book;
use App\Enum\Sort;
use App\Library\ElasticSearch\ElasticSearchClient;
use App\Model\BookFilterModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Elasticsearch\ClientBuilder;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsSetQuery;
use ReflectionClass;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function getBooks(BookFilterModel $filterModel): \stdClass
    {
        $esSearchClient = ElasticSearchClient::build()
            ->searchDocuments(BookDocument::class);

        if($filterModel->getSearchText() !== "")
        {
            $esSearchClient->addQueryMatch('title', $filterModel->getSearchText());
        }

        if($filterModel->getBarcode() !== "")
        {
            $esSearchClient->addQueryMatch('barcode', $filterModel->getBarcode());
        }

        if(!empty($filterModel->getAuthorIds()))
        {
            $esSearchClient->addQueryMatch('authors.id', $filterModel->getAuthorIds());
        }

        if(!empty($filterModel->getPublisherIds()))
        {
            $esSearchClient->addQueryMatch('publishers.id', $filterModel->getPublisherIds());
        }

        if(!empty($filterModel->getTranslatorIds()))
        {
            $esSearchClient->addQueryMatch('translators.id', $filterModel->getPublisherIds());
        }

      /*  if($filterModel->getSort() != null)
        {
            $esSearchClient->setSort('title', Sort::ASCENDING);
        } */

        return $esSearchClient->get();
    }

    public function getBooksCount(User $user, BookFilterModel $filterModel) : int
    {
        return $this->getBooksBaseQuery($user, $filterModel)
            ->select('count(ubl.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getBooksBaseQuery(User $user, BookFilterModel $filterModel) : ElasticSearchClient
    {
        $query = $this
            ->createQueryBuilder('b')
            ->where('ubl.user = :user')
            ->setParameter('user', $user);

        if($filterModel->getSearchText() !== null)
        {
            $query->andWhere('ubl.name LIKE :name')
                ->setParameter('name',  '%' . $filterModel->getSearchText() . '%');
        }

        return $query;
    }
}
