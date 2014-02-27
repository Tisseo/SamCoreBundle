<?php

namespace CanalTP\IussaadCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use CanalTP\IussaadCoreBundle\Entity\Role;

class FixturesRole extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)       
    {
        //  On crée les rôles par défaut de symfony 2
        $roleUser = new Role();
        $roleUser->setName('Utilisateur');
        $roleUser->setRole('ROLE_USER');
        $roleUser->addApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleUser);

        $roleReferent = new Role();
        $roleReferent->setName('Référent');
        $roleReferent->setRole('ROLE_REFERENT');
        $roleReferent->addParent($roleUser);
        $roleReferent->addApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleReferent);

        $roleAdmin = new Role();
        $roleAdmin->setName('Administrateur');
        $roleAdmin->setRole('ROLE_ADMIN');
        $roleAdmin->addParent($roleReferent);
        $roleAdmin->addApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleAdmin);

        $roleSuperAdmin = new Role();
        $roleSuperAdmin->setName('Super Administrateur');
        $roleSuperAdmin->setRole('ROLE_SUPER_ADMIN');
        $roleSuperAdmin->addParent($roleAdmin);
        $roleSuperAdmin->addApplication($this->getReference('app-iussaad'));
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
