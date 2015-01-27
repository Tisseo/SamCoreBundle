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

use CanalTP\SamEcoreUserManagerBundle\Entity\User;
use CanalTP\SamCoreBundle\Entity\Application;
use CanalTP\SamCoreBundle\Entity\Customer;
use CanalTP\SamCoreBundle\Entity\Role;

class FixtureSam extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        for ($i=0; $i < 300; ++$i) {
            $customer = new Customer();
            $customer->setName('customer_' . $i);

            $em->persist($customer);
        }
        $em->flush();
    }

    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 4;
    }
}
