<?php

namespace App\Repository;

use App\Entity\Specialiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Specialiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialiste[]    findAll()
 * @method Specialiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialiste::class);
    }
    public function SpecialisteAcceptee(){
        $query=$this->createQueryBuilder('s')
            ->where("s.Etat = :etat")
            ->setParameter('etat',"Accepté")
            ;
         return $query->getQuery()->getResult();
         
     }
     public function SpecialisteByspec(string $specialite):array{
        $query=$this->createQueryBuilder('s')
            ->where("s.specialite = :spec")
            ->setParameter('spec',$specialite)
            ->andwhere("s.Etat = :etat")
            ->setParameter('etat',"Accepté")
            ;
         return $query->getQuery()->getResult();
         
     }
     public function SpecialisteById($id_specialiste){
        $query=$this->createQueryBuilder('s')
            ->where("s.id = :id_specialiste")
            ->setParameter("id_specialiste",$id_specialiste)
            ;
         return $query->getQuery()->getOneOrNullResult();
       }


       public function SpecialistenonAcceptId($id_specialiste){
        $query=$this->createQueryBuilder('s')
            ->where("s.id = :id_specialiste")
            ->setParameter("id_specialiste",$id_specialiste)
            ;
         return $query->getQuery()->getOneOrNullResult();
       }

       public function SpecialistNonAccept():array{
        $query=$this->createQueryBuilder('s')
            ->where("s.Etat = :etat")
            ->setParameter('etat',"En Attente d'acceptation")
            ;
         return $query->getQuery()->getResult();  
     }
     public function SpecialisteNonacceptByspec(string $specialite):array{
        $query=$this->createQueryBuilder('s')
            ->where("s.specialite = :spec")
            ->setParameter('spec',$specialite)
            ->andwhere("s.Etat = :etat")
            ->setParameter('etat',"En Attente d'acceptation")
            ;
         return $query->getQuery()->getResult();
         
     }

     public function SpecialisteFindByUser($id)
    {
        $query=$this->createQueryBuilder('s')
             ->join("s.User","Use")
             ->where("Use.id = :useId")
             ->setParameter('useId',$id)
             ;
    return $query->getQuery()->getOneOrNullResult();
    }
   





    // /**
    //  * @return Specialiste[] Returns an array of Specialiste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Specialiste
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
