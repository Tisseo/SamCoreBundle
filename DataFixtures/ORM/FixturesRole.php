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
        $roles = array(
            // SAM
            array(
                'name'  => 'Utilisateur',
                'canonicalName' => 'ROLE_USER',
                'permissions'  => array(
                    'BUSINESS_VIEW_USER',
                    'BUSINESS_MANAGE_USER',
                    'BUSINESS_MANAGE_USER_ROLE',
                    'BUSINESS_MANAGE_USER_PERIMETER',
                    'BUSINESS_VIEW_ROLE',
                    'BUSINESS_MANAGE_ROLE',
                ),
                'editable' => true,
                'application' => $this->getReference('app-sam'),
                'reference' => 'role-user-sam'
            ),
            array(
                'name'  => 'Référent',
                'canonicalName' => 'ROLE_REFERENT',
                'permissions'  => array(),
                'editable' => true,
                'application' => $this->getReference('app-sam'),
                'reference' => 'role-referent-sam'
            ),
             array(
                'name'  => 'Observateur',
                'canonicalName' => 'ROLE_OBS',
                'permissions'  => array(),
                'application' => $this->getReference('app-sam'),
                'reference' => 'role-obs-sam'
            ),
            array(
                'name'  => 'Administrateur',
                'canonicalName' => 'ROLE_ADMIN',
                'permissions'  => array(
                    'BUSINESS_VIEW_USER',
                    'BUSINESS_MANAGE_USER',
                    'BUSINESS_MANAGE_USER_ROLE',
                    'BUSINESS_MANAGE_USER_PERIMETER',
                    'BUSINESS_MANAGE_PERMISSION',
                    'BUSINESS_VIEW_ROLE',
                    'BUSINESS_MANAGE_ROLE',
                ),
                'editable' => true,
                'application' => $this->getReference('app-sam'),
                'reference' => 'role-admin-sam'
            ),
            array(
                'name'  => 'Super Admin',
                'canonicalName' => 'ROLE_SUPER_ADMIN',
                'permissions'  => array(
                    'BUSINESS_VIEW_USER',
                    'BUSINESS_MANAGE_USER',
                    'BUSINESS_MANAGE_USER_ROLE',
                    'BUSINESS_MANAGE_USER_PERIMETER',
                    'BUSINESS_MANAGE_PERMISSION',
                    'BUSINESS_VIEW_ROLE',
                    'BUSINESS_MANAGE_ROLE',
                ),
                'editable' => false,
                'application' => $this->getReference('app-sam'),
                'reference' => 'role-super-admin-sam'
            )
        );

        foreach ($roles as $role) {
            $entity = new Role();
            $entity->setName($role['name']);
            $entity->setCanonicalName($role['canonicalName']);
            $entity->setPermissions($role['permissions']);
            $entity->setApplication($role['application']);
            $entity->setIsEditable(isset($role['editable']) ? $role['editable'] : false);
            $em->persist($entity);

            $this->addReference($role['reference'], $entity);
        }

        $em->flush();
    }

     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
