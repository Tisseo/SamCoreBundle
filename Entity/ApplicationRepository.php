<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends EntityRepository
{
    
    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('a')
                ->getQuery()
                ->getResult();
    }

}