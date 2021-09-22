<?php

namespace App\Repository;

use App\Entity\CompteJour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteJour|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteJour|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteJour[]    findAll()
 * @method CompteJour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteJourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteJour::class);
    }

    // /**
    //  * @return CompteJour[] Returns an array of CompteJour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompteJour
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
