<?php

/**
 * Description courte de la classe Fixture
 *
 * @copyright  Copyright (c) 2008-2014 CanalTP. (http://www.canaltp.fr/)
 * @author     Thomas Chevily <thomas.chevily@canaltp.fr>
 * @version
 * @since 2014/05/05
 */

namespace CanalTP\SamCoreBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use CanalTP\SamCoreBundle\Entity\Application;
use CanalTP\SamCoreBundle\Entity\Role;
use CanalTP\SamEcoreUserManagerBundle\Entity\User;

abstract class Fixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * Entity Manager
     *
     * @var Doctrine\Common\Persistence\ObjectManager
     */
    protected $em;

    /**
     * Crée un utilisateur dans le schema public.
     *
     * @param array $data Tableau avec des infos du compte (username, firstname, lastname, email, password)
     * @param array $roles Tableas des objets role
     *
     * @return CanalTP\SamEcoreUserManagerBundle\Entity\User
     */
    protected function createUser($data, array $roles = array())
    {
        $user = new User();
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstname']);
        $user->setLastName($data['lastname']);
        $user->setEnabled(true);
        $user->setEmail($data['email']);
        $user->setPlainPassword($data['password']);
        $user->setUserRoles($roles);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Crée l'enregistrement dans la table tj_application_role.
     *
     * @param type $name
     * @param type $route
     * @return \CanalTP\SamCoreBundle\Entity\Application
     */
    protected function createApplication($name, $route)
    {
        $entity = new Application($name);
        $entity->setDefaultRoute($route);
        $entity->setCanonicalName(strtolower($name));


        $this->em->persist($entity);
        $this->em->flush();

        $this->addReference('app-' . $entity->getCanonicalName(), $entity);

        return $entity;
    }

    /**
     * Crée un role.
     *
     * @param string $name Nom du role
     * @param string $cannonicalName Nom cannonical du role
     * @param \CanalTP\SamCoreBundle\Entity\Application $app Application à associé
     * @param array $permissions Liste des permissions
     *
     * @return \CanalTP\SamCoreBundle\Entity\Role
     */
    protected function createApplicationRole($name, $cannonicalName, Application $app, array $permissions = array(), $isEditable = true)
    {
        //créer un role vide ?!
        $role = new Role();
        $role->setName($name);
        $role->setCanonicalName($cannonicalName);
        $role->setApplication($app);
        $role->setPermissions($permissions);
        $role->setIsEditable($isEditable);

        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }
}
