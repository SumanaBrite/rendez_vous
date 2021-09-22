<?php

namespace App\Repository;

use App\Entity\Guichet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Guichet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guichet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guichet[]    findAll()
 * @method Guichet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuichetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guichet::class);
    }

    // /**
    //  * @return Guichet[] Returns an array of Guichet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Guichet
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
