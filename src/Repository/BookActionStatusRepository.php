<?php

namespace App\Repository;

use App\Entity\BookActionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookActionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookActionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookActionStatus[]    findAll()
 * @method BookActionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookActionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookActionStatus::class);
    }

    // /**
    //  * @return BookActionStatus[] Returns an array of BookActionStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookActionStatus
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
