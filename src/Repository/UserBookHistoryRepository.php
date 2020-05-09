<?php

namespace App\Repository;

use App\Entity\UserBookHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserBookHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserBookHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserBookHistory[]    findAll()
 * @method UserBookHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserBookHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserBookHistory::class);
    }

    // /**
    //  * @return UserBookHistory[] Returns an array of UserBookHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserBookHistory
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
