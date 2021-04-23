<?php

namespace App\Repository;

use App\Entity\ExamenBio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExamenBio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenBio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenBio[]    findAll()
 * @method ExamenBio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenBioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamenBio::class);
    }

    public function findExamenBio(int $id)
    {
        $query=$this->createQueryBuilder('e')
            ->join("e.demande", 'dem')
            ->where("dem.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }
 


    // /**
    //  * @return ExamenBio[] Returns an array of ExamenBio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExamenBio
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
