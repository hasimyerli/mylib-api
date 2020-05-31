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

    public function getTotalComment($bookId)
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->andWhere('c.book = :book')
            ->setParameter('book', $bookId)
            ->andWhere('c.status = :status')
            ->setParameter('status', Status::ACTIVE)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getComments($bookId, $page = 1, $limit = 20)
    {
        $page = ($page > 1) ? $page: 1;
        $limit = $limit < 100 ? $limit : 20;

        $qb = $this->createQueryBuilder('c');
        $qb->where('c.parent is null');

        $qb->andWhere('c.book = :book')
            ->setParameter('book', $bookId);

        $qb->andWhere('c.status = :status');
        $qb->setParameter('status', Status::ACTIVE);

        $qb->setMaxResults($limit);
        $qb->setFirstResult(($page-1) * $limit);

        $qb->orderBy('c.id', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
