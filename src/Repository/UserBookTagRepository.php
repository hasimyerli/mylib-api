<?php

namespace App\Repository;

use App\Entity\UserBookTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    // /**
    //  * @return UserBookTag[] Returns an array of UserBookTag objects
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
    public function findOneBySomeField($value): ?UserBookTag
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
