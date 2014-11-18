<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use CanalTP\SamCoreBundle\Entity\Application;

trait ApplicationTrait
{
    /**
     * Crée l'enregistrement dans la table tj_application_role.
     *
     * @param type $name
     * @param type $route
     * @return \CanalTP\SamCoreBundle\Entity\Application
     */
    public function createApplication(ObjectManager $om, $name, $route)
    {
        $entity = new Application($name);

        $entity->setDefaultRoute($route);
        $entity->setCanonicalName(strtolower($name));
        $om->persist($entity);
        $this->addReference('app-' . $entity->getCanonicalName(), $entity);
        return $entity;
    }
}
