<?php

namespace App\Repository;

use App\Entity\ExamenClinique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExamenClinique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenClinique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenClinique[]    findAll()
 * @method ExamenClinique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenCliniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamenClinique::class);
    }
    
    public function findExamenClinique(int $id)
    {
        $query=$this->createQueryBuilder('e')
            ->join("e.demande", 'dem')
            ->where("dem.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return ExamenClinique[] Returns an array of ExamenClinique objects
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
    public function findOneBySomeField($value): ?ExamenClinique
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
