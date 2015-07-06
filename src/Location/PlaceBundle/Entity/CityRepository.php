<?php

namespace Location\PlaceBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends EntityRepository
{   
    public function getNearestCities($lat, $lng)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.lat BETWEEN :lat-0.2 AND :lat+0.2')
            ->andWhere('c.lng BETWEEN :lng-0.2 AND :lng+0.2')
            ->andWhere('c.lng <> :lng')
            ->andWhere('c.lat <> :lat')
            ->setParameter('lat', $lat)
            ->setParameter('lng', $lng)
            ->orderBy('c.name', 'ASC')
            ->getQuery();

        return $qb->getResult();

    }
}
