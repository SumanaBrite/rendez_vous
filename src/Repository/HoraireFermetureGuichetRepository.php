<?php

namespace App\Repository;

use App\Entity\HoraireFermetureGuichet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HoraireFermetureGuichet|null find($id, $lockMode = null, $lockVersion = null)
 * @method HoraireFermetureGuichet|null findOneBy(array $criteria, array $orderBy = null)
 * @method HoraireFermetureGuichet[]    findAll()
 * @method HoraireFermetureGuichet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoraireFermetureGuichetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HoraireFermetureGuichet::class);
    }

    // /**
    //  * @return HoraireFermetureGuichet[] Returns an array of HoraireFermetureGuichet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HoraireFermetureGuichet
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
