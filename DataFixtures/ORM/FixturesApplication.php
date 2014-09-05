<?php

namespace CanalTP\SamCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use CanalTP\SamCoreBundle\Entity\Application;

class FixturesApplication extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $appSam = new Application('Sam');
        $appSam->setCanonicalName('samcore');
        $appSam->setDefaultRoute('/admin');
        $em->persist($appSam);

        $em->flush();

        $this->addReference('app-sam', $appSam);
    }

     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
