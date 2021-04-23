<?php

namespace App\Repository;

use App\Entity\ReponseRens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReponseRens|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseRens|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseRens[]    findAll()
 * @method ReponseRens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseRensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseRens::class);
    }

    // /**
    //  * @return ReponseRens[] Returns an array of ReponseRens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReponseRens
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
