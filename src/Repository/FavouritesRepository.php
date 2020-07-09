<?php

namespace App\Repository;

use App\Entity\Favourites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * FavouritesRepository.
 *
 * @method Favourites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favourites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favourites[]    findAll()
 * @method Favourites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouritesRepository extends ServiceEntityRepository
{
    /**
     * __construct.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favourites::class);
    }
}
