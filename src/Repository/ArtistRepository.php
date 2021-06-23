<?php

namespace App\Repository;

use App\Entity\Artist;
use App\Entity\Category;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }


    // public function findByCategory(int $categoryId): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT a.name, a.isLive, a.description
    //         FROM App\Entity\Artist a
    //         INNER JOIN App\Entity\Category c ON a.category = c.id
    //         WHERE c.id =:categoryIdToSet'
    //     )
    //     ->setParameter('categoryIdToSet', $categoryId)
    //     ;

    //     dd($query->getResult());

    //     return $query->getResult();
    // }
    
    

    /**
     * @return Artist[] Returns an array of Artist objects
     */
    
    public function findByCategory($value)
    {
        return $this->createQueryBuilder('a')
            ->select('a.name' , 'a.isLive', 'a.description')
            ->innerJoin('c.id', 'a', 'WITH', 'a.category = c.id')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()

            // innerJoin('c.phones', 'p', Join::ON, 'c.id = p.customerId')


            // ->andWhere('a.exampleField = :val')
            // ->setParameter('val', $value)
            // ->orderBy('a.id', 'ASC')
            // ->setMaxResults(10)
            // ->getQuery()
            // ->getResult()
        ;


        // $qb->select('c')
        // ->innerJoin('c.phones', 'p', 'WITH', 'p.phone = :phone')
        // ->where('c.username = :username');
    }
    


    // /**
    //  * @return Artist[] Returns an array of Artist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Artist
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
