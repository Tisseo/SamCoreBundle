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
    protected function createApplicationRole(ObjectManager $om, $name, $cannonicalName, $appReference, $roleReference, $isEditable = true)
    {
        $role = new Role();

        $role->setName($name);
        $role->setCanonicalName($cannonicalName);
        $role->setApplication($this->getReference($appReference));
        $role->setPermissions($this->permissions[$roleReference]);
        $role->setIsEditable($isEditable);
        $om->persist($role);
        $this->addReference('role-' . $roleReference, $role);
        return $role;
    }
}
