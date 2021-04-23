<?php

namespace App\Repository;

use App\Entity\Generaliste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Generaliste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Generaliste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Generaliste[]    findAll()
 * @method Generaliste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Generaliste::class);
    }
    
    
    public function findProfil(int $id)
    {
        $query=$this->createQueryBuilder('g')
            ->join("g.user",'user')
            ->where("user.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }

    public function GeneralistById($idg){
        $query=$this->createQueryBuilder('g')
            ->where("g.id = :idg")
            ->setParameter("idg",$idg)
            ;
         return $query->getQuery()->getOneOrNullResult();
       }

    public function generalisteNonAccept():array{
        $query=$this->createQueryBuilder('g')
            ->where("g.etat = :etat")
            ->setParameter('etat',"En Attente d'acceptation")
            ;
         return $query->getQuery()->getResult();  
     }
    

    // /**
    //  * @return Generaliste[] Returns an array of Generaliste objects
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
    public function findOneBySomeField($value): ?Generaliste
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
