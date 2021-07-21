<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function search($term, int $category = null, string $order = 'desc', int $limit = 20, int $offset = 0, bool $active = false)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.createdAt', $order)
        ;

        if(!$active) {
            $qb->andWhere('a.active = TRUE')
                ->join('a.category','c')
                ->andWhere('c.active = TRUE');
        }

        if ($term) {
            $qb
                ->andWhere('LOWER(a.title) LIKE LOWER(:like)')
                ->setParameter('like', '%'.$term.'%')
            ;
        }

        if ($category) {
            $qb
                ->andWhere('a.category = :category')
                ->setParameter('category', $category)
            ;
        }

        $qb->setFirstResult($offset)->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
