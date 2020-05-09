<?php

namespace App\Repository;

use App\Entity\Translator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Translator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translator[]    findAll()
 * @method Translator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translator::class);
    }

    // /**
    //  * @return Translator[] Returns an array of Translator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Translator
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
