<?php

namespace App\Service;


use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\LazyCriteriaCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

abstract class AbstractService
{
    /**
     * @var EntityRepository
     */
    protected $_repository;

    /**
     * @var EntityManager
     */
    protected $_em;

    /**
     * @param EntityManagerInterface $em
     * @param $entity
     */
    public function __construct($entity, EntityManagerInterface $em)
    {
        $this->_em = $em;
        $this->_repository = $this->_em->getRepository($entity);
    }

    public function beginTransaction()
    {
        $this->_em->beginTransaction();
    }

    public function commit()
    {
        $this->_em->commit();
    }

    public function rollback()
    {
        $this->_em->rollback();
    }

    /**
     * @return array|object[]
     */
    public function findAll()
    {
        return $this->_repository->findAll();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|object[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->_repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param $id
     * @param int $lockMode
     * @param null $lockVersion
     * @return null|object
     */
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        return $this->_repository->find($id, $lockMode, $lockVersion);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->_repository->findOneBy($criteria, $orderBy);
    }

    /**
     * @param Criteria $criteria
     * @return Collection|LazyCriteriaCollection
     */
    public function matching(Criteria $criteria)
    {
        return $this->_repository->matching($criteria);
    }

    public function save($object)
    {
        try {
            $this->_em->persist($object);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {
            //TODO:: ...
        } catch (ORMException $e) {
            //TODO:: ...
        }
    }

    public function delete($object)
    {
        try {
            $this->_em->remove($object);
            $this->_em->flush();
        } catch (OptimisticLockException $e) {
            //TODO:: ...
        } catch (ORMException $e) {
            //TODO:: ...
        }
    }

    protected function getRepository()
    {
        return $this->_repository;
    }
}