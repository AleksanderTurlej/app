<?php

namespace App\Repository;

use App\Entity\Medicine;
use App\Entity\Substance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Medicine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicine[]    findAll()
 * @method Medicine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicineRepository extends ServiceEntityRepository
{
    public const SEARCH_BY_DISEASES = 1;
    public const SEARCH_BY_MEDICINCES = 2;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicine::class);
    }

    /**
     * @param string|null $name
     *
     * @return Medicine[] Returns an array of Medicine objects
     */
    public function search(Request $request)
    {
        $searchBy = $request->get('searchBy');
        $name = $request->get('name');
        $builder = $this->createQueryBuilder('m');

        if(null === $name){

            return $builder
                ->getQuery();

        }
        if (self::SEARCH_BY_DISEASES == $searchBy) {
//            dd($searchBy);
            $builder
                ->join('m.diseases', 'd')
                ->andWhere('d.name LIKE :string')

            ->setParameter('string', '%'.$name.'%', \PDO::PARAM_STR);

        return $builder
            ->getQuery();
        }
        else {
//            dd($searchBy);

            $builder->andWhere('m.name LIKE :string')
                ->setParameter('string', '%' . $name . '%', \PDO::PARAM_STR);

            return $builder
                ->getQuery();
        }
    }


}
