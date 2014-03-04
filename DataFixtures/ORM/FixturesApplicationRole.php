<?php

namespace CanalTP\IussaadCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use CanalTP\IussaadCoreBundle\Entity\ApplicationRole;

class FixturesApplicationRole extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)       
    {
        //  On crée les rôles par défaut de symfony 2
        $roleUser = new ApplicationRole();
        $roleUser->setRole($this->getReference('role-user'));
        $roleUser->setName('Utilisateur');
        $roleUser->setCanonicalRole('ROLE_USER');
        $roleUser->setApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleUser);

        $roleReferent = new ApplicationRole();
        $roleReferent->setRole($this->getReference('role-referent'));
        $roleReferent->setName('Référent');
        $roleReferent->setCanonicalRole('ROLE_REFERENT');
        $roleReferent->addParent($roleUser);
        $roleReferent->setApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleReferent);

        $roleAdmin = new ApplicationRole();
        $roleAdmin->setRole($this->getReference('role-admin'));
        $roleAdmin->setName('Administrateur');
        $roleAdmin->setCanonicalRole('ROLE_ADMIN');
        $roleAdmin->addParent($roleReferent);
        $roleAdmin->setApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleAdmin);

        $roleSuperAdmin = new ApplicationRole();
        $roleSuperAdmin->setRole($this->getReference('role-super-admin'));
        $roleSuperAdmin->setName('Super Administrateur');
        $roleSuperAdmin->setCanonicalRole('ROLE_SUPER_ADMIN');
        $roleSuperAdmin->addParent($roleAdmin);
        $roleSuperAdmin->setApplication($this->getReference('app-iussaad'));
        //  On la persiste
        $em->persist($roleSuperAdmin);
                
        //  On déclenche l'enregistrement
        $em->flush();
        $this->addReference('role-app-user', $roleUser);
        $this->addReference('role-app-referent', $roleReferent);
        $this->addReference('role-app-admin', $roleAdmin);
        $this->addReference('role-app-super-admin', $roleSuperAdmin);
    }
    
     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
