<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use CanalTP\SamCoreBundle\Entity\Application;
use Doctrine\Common\Persistence\ObjectManager;

trait ApplicationTrait
{
    /**
     * Crée l'enregistrement dans la table tj_application_role.
     *
     * @param string $name
     * @param string $route
     *
     * @return Application
     */
    public function createApplication(ObjectManager $om, $name, $route)
    {
        $entity = new Application($name);
        $entity->setDefaultRoute($route);
        $entity->setCanonicalName(strtolower($name));

        $om->persist($entity);

        $this->addReference('app-' . $entity->getCanonicalName(), $entity);
    }
}
