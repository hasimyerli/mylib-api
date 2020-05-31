<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserBookList;
use App\Model\BaseFilterModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserBookList|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBookList|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBookList[]    findAll()
 * @method UserBookList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBookListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBookList::class);
    }

    public function getUserBookLists(User $user, BaseFilterModel $filterModel)
    {
        return $this->getUserBookListsBaseQuery($user, $filterModel)
            ->setMaxResults($filterModel->getLimit())
            ->addOrderBy('ubl.' . $filterModel->getSort(), $filterModel->getOrder())
            ->setFirstResult($filterModel->getOffset())
            ->getQuery()->getResult();
    }

    public function getUserBookListsCount(User $user, BaseFilterModel $filterModel) : int
    {
        return $this->getUserBookListsBaseQuery($user, $filterModel)
            ->select('count(ubl.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getUserBookListsBaseQuery(User $user, BaseFilterModel $filterModel) : QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('ubl')
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
