<?php

namespace CanalTP\SamCoreBundle\Tests\Functional\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\AuthenticationEvents;

abstract class AbstractControllerTest extends BaseControllerTest
{
    /**
     * This variable check if the bdd was mocked.
     *
     * @var boolean
     */
    protected static $mockDb = true;

    private function mockDb()
    {
        $this->runConsole("sam:database:purge", array('-e' => 'test_sam'));
    }

    protected function logIn()
    {
        parent::logIn('sam', 'sam', 'sam@canaltp.fr', array('ROLE_ADMIN'), 'sam_selected_application', 'sam');
    }

    public function setUp($login = true)
    {
        $this->client = parent::createClient(array('environment' => 'test_sam'));
        parent::setUp();

        if (self::$mockDb === true) {
            self::$mockDb = false;

            $this->mockDb();
        }
        if ($login == true)
            $this->logIn();
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
