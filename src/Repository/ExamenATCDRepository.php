<?php

namespace App\Repository;

use App\Entity\ExamenATCD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExamenATCD|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenATCD|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenATCD[]    findAll()
 * @method ExamenATCD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenATCDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamenATCD::class);
    }



    public function findExamenATCD(int $id)
    {
        $query=$this->createQueryBuilder('e')
            ->join("e.demande", 'dem')
            ->where("dem.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }
 
    
    /*
    public function findOneBySomeField($value): ?ExamenATCD
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
