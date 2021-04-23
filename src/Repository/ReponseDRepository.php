<?php

namespace App\Repository;

use App\Entity\ReponseD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReponseD|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseD|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseD[]    findAll()
 * @method ReponseD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseDRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseD::class);
    }

    public function findReponseD(int $idD): array
    {
        $query=$this->createQueryBuilder('r')
            ->join("r.demande", 'd')
            ->where("d.id = :idD")
            ->setParameter('idD', $idD)
            ;
        return $query->getQuery()->getResult();
    }

    public function findReponseDbyspecialiste(int $iduser, int $idD): array
    {
        $query=$this->createQueryBuilder('r')
            ->join("r.demande", 'd')
            ->where("d.id = :idD")
            ->setParameter('idD', $idD)
            ->join("r.User","U")
            ->where("U.id = : iduser")
            ->setParameter("iduser",$iduser)
            ;
        return $query->getQuery()->getResult();
    }

    

    
}
