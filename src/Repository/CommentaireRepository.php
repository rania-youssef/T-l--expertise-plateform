<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }


    public function findCommentaires(int $id): array
    {
        $query=$this->createQueryBuilder('c')
            ->join("c.demande", 'd')
            ->where("d.id = :id")
            ->setParameter('id', $id)
            ;
        return $query->getQuery()->getResult();
    }

    public function findCommentairesBySujet(string $sujet,int $id): array
    {
        $query=$this->createQueryBuilder('c')
            ->join("c.demande", 'd')
            ->where("d.id = :id")
            ->setParameter('id',$id)
            ->andwhere("c.sujet = :sujet")
            ->setParameter('sujet', $sujet)
            ->orderBy('c.date', 'ASC')
            ;
        return $query->getQuery()->getResult();
    }
    public function findCommentairesById(int $id)
    {
        $query=$this->createQueryBuilder('c')
            ->where("c.id = :id")
            ->setParameter('id', $id)
            ;
        return $query->getQuery()->getOneOrNullResult();
    }
    



    // /**
    //  * @return Commentaire[] Returns an array of Commentaire objects
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
    public function findOneBySomeField($value): ?Commentaire
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
