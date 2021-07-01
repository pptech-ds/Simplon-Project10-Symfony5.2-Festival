<?php

namespace App\Repository;

use App\Entity\Artist;
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
     * Returns all Annonces per page
     * @return Artist[] Returns an array of Artist objects 
     */
    public function findPaginatedArtists($page, $limit)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->addSelect('(SELECT COUNT(b.id) 
            FROM App\Entity\Artist b) AS NbArtists')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;

        return $query->getQuery()->getResult();
    }


    /**
     * Returns all Annonces per page
     * @return Artist[] Returns an array of Artist objects 
     */
    public function findPaginatedArtistsByCategory(int $category = null, $page, $limit)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->addSelect('(
                SELECT COUNT(b.id) 
                FROM App\Entity\Artist b
                WHERE b.category = :id
                ) AS NbArtists')
            ->innerJoin('a.category', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $category)
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
            ;

        // dd($query->getQuery()->getResult());
        
        return $query->getQuery()->getResult();
    }
    

    /**
     * Returns all Annonces per page
     * @return Artist[] Returns an array of Artist objects
     */
    public function findArtitsInConcert()
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.concert IS NOT NULL')
        ;
        return $query->getQuery()->getResult();
    }

}
