<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserBookTag;
use App\Model\BaseFilterModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserBookTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBookTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBookTag[]    findAll()
 * @method UserBookTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBookTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBookTag::class);
    }

    public function getUserBookTags(User $user, BaseFilterModel $filterModel)
    {
        return $this->getUserBookTagsBaseQuery($user, $filterModel)
            ->setMaxResults($filterModel->getLimit())
            ->addOrderBy('ubt.' . $filterModel->getSort(), $filterModel->getOrder())
            ->setFirstResult($filterModel->getOffset())
            ->getQuery()->getResult();
    }

    public function getUserBookTagsCount(User $user, BaseFilterModel $filterModel) : int
    {
        return $this->getUserBookTagsBaseQuery($user, $filterModel)
            ->select('count(ubt.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getUserBookTagsBaseQuery(User $user, BaseFilterModel $filterModel) : QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('ubt')
            ->where('ubt.user = :user')
            ->setParameter('user', $user);

        if($filterModel->getSearchText() !== null)
        {
            $query->andWhere('ubt.name LIKE :name')
                ->setParameter('name',  '%' . $filterModel->getSearchText() . '%');
        }

        return $query;
    }
}
