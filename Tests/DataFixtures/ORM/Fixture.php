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
use CanalTP\SamCoreBundle\Entity\Application;
use CanalTP\SamCoreBundle\Entity\Role;
use CanalTP\SamEcoreUserManagerBundle\Entity\User;

abstract class Fixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
