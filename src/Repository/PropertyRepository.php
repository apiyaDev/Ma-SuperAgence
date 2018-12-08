<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\PropertySearch;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * Return Query
     */
    public function getAllVisible(PropertySearch $search)
    {
        $query =  $this->createQueryBuilder('p')
                        ->andWhere('p.sold = :val')
                        ->setParameter('val', false)
                        ->orderBy('p.id', 'DESC');

        if ($search->getMaxPrice())
        {
            $query = $query->andWhere('p.price <= :maxprice');
                     $query->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()) 
        {
            $query = $query->andWhere('p.surface >= :minsurface');
            $query->setParameter('minsurface', $search->getMinSurface());
        }       

        if ($search->getOption()->count() > 0)
        {   
            foreach ($search->getOption() as $k => $option) {
                $query = $query->andWhere(':option MEMBER OF p.options');
                $query->setParameter('option', $option);
            }
        }

        return  $query->getQuery();    
    }

    /**
     * Return Latest Four Property[]
     */
    public function latestProp()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = :val')
            ->setParameter('val', false)
            ->setMaxResults(4)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();        
    }


    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
