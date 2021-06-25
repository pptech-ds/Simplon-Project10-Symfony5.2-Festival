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


    /**
     * Recherche les artistes en fonction de la catégorie
     * @return Artist[] Returns an array of Artist objects
     */    
    public function findByCategory(int $category = null)
    {
        $query = $this->createQueryBuilder('a'); // SELECT * FROM artist
            // ->select('a.id', 'a.name' , 'a.isLive', 'a.description', 'a.concert'); 
            if($category != null) {
                $query->innerJoin('a.category', 'c');
                $query->andWhere('c.id = :id')->setParameter('id', $category);
            } 
        return $query->getQuery()->getResult();
    }


    /**
     * Recherche les artistes en fonction de la catégorie
     * @return Artist[] Returns an array of Artist objects
     */    
    public function findAllAndCount()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a.id, a.name, a.description, a.isLive, c.id AS categoryId, c.name AS categoryName, c.color AS categoryColor, (SELECT COUNT(b.id) 
            FROM App\Entity\Artist b) AS NbArtists 
            FROM App\Entity\Artist a
            INNER JOIN a.category c
            WHERE a.category = c.id'
        );
        return $query->getResult();
    }


    /**
     * Returns all Annonces per page
     * @return void 
     */
    public function getPaginatedArtists($page, $limit)
    {
        $query = $this->createQueryBuilder('a')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
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
