<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use CanalTP\SamCoreBundle\Entity\Role;

class FixturesRole extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)       
    {
        //  On crée les rôles par défaut de symfony 2
        $roleUser = new Role();
        //  On la persiste
        $em->persist($roleUser);

        $roleReferent = new Role();
        //  On la persiste
        $em->persist($roleReferent);

        $roleAdmin = new Role();
        //  On la persiste
        $em->persist($roleAdmin);

        $roleSuperAdmin = new Role();
        //  On la persiste
        $em->persist($roleSuperAdmin);
                
        //  On déclenche l'enregistrement
        $em->flush();
        $this->addReference('role-user', $roleUser);
        $this->addReference('role-referent', $roleReferent);
        $this->addReference('role-admin', $roleAdmin);
        $this->addReference('role-super-admin', $roleSuperAdmin);
    }
    
     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
