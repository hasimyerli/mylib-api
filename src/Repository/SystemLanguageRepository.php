<?php

namespace App\Repository;

use App\Entity\SystemLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemLanguage[]    findAll()
 * @method SystemLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemLanguage::class);
    }

    // /**
    //  * @return SystemLanguage[] Returns an array of SystemLanguage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SystemLanguage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
