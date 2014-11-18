<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use CanalTP\SamCoreBundle\Entity\Role;

trait RoleTrait
{
    /**
     * Crée un role.
     *
     * @return \CanalTP\SamCoreBundle\Entity\Role
     */
    public function createApplicationRole(ObjectManager $om, $data)
    {
        $role = new Role();

        $role->setName($data['name']);
        $role->setCanonicalName($data['canonicalName']);
        $role->setApplication($this->getReference($data['application']));
        $role->setPermissions($data['permissions']);
        $role->setIsEditable($data['isEditable']);
        $om->persist($role);
        $this->addReference($role->getCanonicalName(), $role);
    }
}
