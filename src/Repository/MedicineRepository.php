<?php

namespace App\Repository;

use App\Entity\Medicine;
use App\Entity\Substance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medicine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicine[]    findAll()
 * @method Medicine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicine::class);
    }

    /**
     * @param string|null $name
     *
     * @return Medicine[] Returns an array of Medicine objects
     */
    public function search(?string $name)
    {
        $builder = $this->createQueryBuilder('m');


        if ($name) {
            $builder->andWhere('m.name LIKE :val')
            ->setParameter('val', '%'.$name.'%');
        }

//        $builder->join('m.substances', 's');
//        $builder->andWhere('s.name = :sub')
//            ->setParameter('sub', $name);
        return $builder
            ->getQuery()
            ->getResult()
        ;




//        return $this->createQueryBuilder('m')
//            ->andWhere('m.name = :val')
//            ->setParameter('val', $name)
//            ->getQuery()
//            ->getResult()
//        ;
    }


    /*
    public function findOneBySomeField($value): ?Medicine
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
