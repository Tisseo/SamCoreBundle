<?php

namespace CanalTP\SamCoreBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

abstract class Fixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
}
