<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }
    /** 
     * recherche les offres en fonction du formulaire
     * @return void
    */
    public function search($mots = null ,$specialite = null ){
        $query = $this->createQueryBuilder('o');
        $query->where('o.active=1');
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(o.titre,o.langage) AGAINST(:mots boolean)>0')
            ->setParameter('mots',$mots);
        }
        if($specialite != null){
          $query->leftJoin('o.specialite', 's');
          $query->andWhere('s.id = :id')
          ->setParameter('id', $specialite);
        }
        return $query->getQuery()->getResult();

    }



     /**
     * Returns number of "Offres" par day
     * @return void 
     */
    public function countByDate(){
        $query = $this->createQueryBuilder('o')
        ->select('SUBSTRING(o.creatAt, 1, 10) as dateOffres, COUNT(o) as count')
             ->groupBy('dateOffres')
         ;
         return $query->getQuery()->getResult();

    }
    // /**
    //  * @return Offre[] Returns an array of Offre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
