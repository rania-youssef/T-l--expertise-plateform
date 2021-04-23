<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Demande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demande[]    findAll()
 * @method Demande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demande::class);
    }

    public function findDemande(int $id)
    {
        $query=$this->createQueryBuilder('d')
            ->where("d.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }
    public function findDemandByUser(int $id):array
    {
        $query=$this->createQueryBuilder('d')
            ->join("d.MedecinEmitteur","em")
            ->where("em.id = :id")
            ->setParameter('id',$id)
            ;
        return $query->getQuery()->getResult();
    }
    public function findDemandeEnAttent(){
       $query=$this->createQueryBuilder('d')
           ->where("d.Etat = :etat")
           ->setParameter('etat',"En Attente d'acceptation")
           ->orderBy('d.date', 'ASC')
           ;
        return $query->getQuery()->getResult();
        
    }
    public function demandeRefus(){
        $query=$this->createQueryBuilder('d')
            ->where("d.Etat = :etat")
            ->setParameter('etat',"Refusé")
            ->orderBy('d.date', 'ASC')
            ;
         return $query->getQuery()->getResult();
         
     }

     public function demandeAttrib(int $idUser):array{
         $query=$this->createQueryBuilder("d")
         ->join("d.SpecialisteAtt","specialiste")
         ->join("specialiste.User","user")
         ->where("user.id = :userId")
         ->setParameter("userId",$idUser)
         ;
         return $query->getQuery()->getResult();
     }
      
     public function findDemandeGeneralise (int $idUser):array{
         $query=$this->createQueryBuilder("d")
               ->where("d.MedecinEmitteur = :idUser")
               ->setParameter('idUser',$idUser)
               ->andwhere("d.Etat = :etat")
               ->setParameter('etat',"En attente d'acceptation")
               ;
    return $query->getQuery()->getResult();

     }

    
}
