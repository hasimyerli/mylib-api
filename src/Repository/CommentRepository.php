<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Enum\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function deleteCommentAndChildComments(Comment $comment)
    {
        $qb = $this->createQueryBuilder('c');
        return $qb->update()
            ->set('c.status', Status::DELETED)
            ->where('c.id=:id')
            ->orWhere('c.parent=:parent')
            ->setParameter('id', $comment->getId())
            ->setParameter('parent', $comment->getId())
            ->getQuery()
            ->execute();
    }

    public function getLastParentComments($bookId, $parentId, $limit = 10)
    {
        $qb = $this->createQueryBuilder('c');

        if ($parentId) {
            $qb->where('c.parent = (:parent)')
                ->setParameter('parent', $parentId);
        } else {
            $qb->where('c.parent is null');
        }

        $qb->andWhere('c.book = :book')
            ->setParameter('book', $bookId);

        $qb->andWhere('c.status = :status')
            ->setParameter('status', Status::ACTIVE);

        $qb->setMaxResults($limit)
            ->orderBy('c.id', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getLastParentChildComments($bookId, $parentIds, $limit = 5)
    {
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->where('c.book = :book')
            ->andWhere('c.parent in (:parent)')
            ->andWhere('c.status = :status')
            ->setParameter('book', $bookId)
            ->setParameter('parent', $parentIds)
            ->setParameter('status', Status::ACTIVE)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
