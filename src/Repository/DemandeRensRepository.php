<?php

namespace App\Repository;

use App\Entity\DemandeRens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeRens|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeRens|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeRens[]    findAll()
 * @method DemandeRens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeRens::class);
    }



    public function demandeRens(int $id): array
    {
        $query=$this->createQueryBuilder('d')
            ->join("d.demande", 'dem')
            ->where("dem.id = :id")
            ->setParameter('id',$id)
            ->orderBy('d.date', 'ASC')
            ;
        return $query->getQuery()->getResult();
    }
    

    // /**
    //  * @return DemandeRens[] Returns an array of DemandeRens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeRens
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
