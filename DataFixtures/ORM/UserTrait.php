<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use CanalTP\SamEcoreUserManagerBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

trait UserTrait
{
    /**
     * Crée un utilisateur dans le schema public.
     *
     * @param array $data Tableau avec des infos du compte (username, firstname, lastname, email, password)
     * @param array $roles Tableas des objets role
     *
     * @return CanalTP\SamEcoreUserManagerBundle\Entity\User
     */
    protected function createUser(ObjectManager $om, $data)
    {
        $user = new User();
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstname']);
        $user->setLastName($data['lastname']);
        $user->setEnabled(true);
        $user->setEmail($data['email']);
        $user->setPlainPassword($data['password']);

        foreach ($data['roles'] as $roleReference) {
            $user->addUserRole($this->getReference($roleReference));
        }

        $om->persist($user);
    }
}
