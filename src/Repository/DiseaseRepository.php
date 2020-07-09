<?php

namespace App\Repository;

use App\Entity\Disease;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * DiseaseRepository.
 *
 * @method Disease|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disease|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disease[]    findAll()
 * @method Disease[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseaseRepository extends ServiceEntityRepository
{
    /**
     * __construct.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disease::class);
    }
}
