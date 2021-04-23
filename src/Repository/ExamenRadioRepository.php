<?php

namespace App\Repository;

use App\Entity\ExamenRadio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExamenRadio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenRadio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenRadio[]    findAll()
 * @method ExamenRadio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenRadioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamenRadio::class);
    }

    public function findExamenRadio(int $id)
    {
        $query=$this->createQueryBuilder('e')
            ->join("e.demande", 'dem')
            ->where("dem.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return ExamenRadio[] Returns an array of ExamenRadio objects
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
    public function findOneBySomeField($value): ?ExamenRadio
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
