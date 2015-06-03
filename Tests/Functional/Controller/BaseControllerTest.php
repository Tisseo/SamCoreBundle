<?php

/**
 * Le controllor de base.
 *
 * @copyright  Copyright (c) 2008-2014 CanalTP. (http://www.canaltp.fr/)
 * @author     Thomas Chevily <thomas.chevily@canaltp.fr>
 * @version
 * @since 2014/04/30
 */

namespace CanalTP\SamCoreBundle\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\AuthenticationEvents;
use CanalTP\SamEcoreUserManagerBundle\Entity\User AS SamUser;

abstract class BaseControllerTest extends WebTestCase {

    protected $customer;
    protected $application;
    protected $firewall = 'main';
    protected $navitiaStubsPath = null;
    protected $tyrStubsPath = null;

    static protected $currentUser = null;

    /**
     * Sets up the fixture.
     *
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        if (false !== ini_get('xdebug.max_nesting_level')) {
            ini_set('xdebug.max_nesting_level', 200);
        }
        $this->initConsole();
        $this->navitiaStubsPath = dirname(__FILE__) . '/stubs/navitia/';
        $this->tyrStubsPath = dirname(__FILE__) . '/stubs/tyr/';
    }

    /**
     * Shuts the kernel down if it was used in the test.
     *
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown() {
        parent::tearDown();
    }

    /**
     * Initie la console.
     */
    protected function initConsole() {
        $kernel = $this->client->getKernel();
        $this->application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->application->setAutoExit(false);
        $this->application->setCatchExceptions(true);
    }

    /**
     * Execute la commande de la consolle.
     *
     * Runs the current application.
     *
     * @param string $command La comande
     * @param array $options options de la commande
     *
     * @throws RuntimeException on error.
     *
     * @return true if everything went fine
     */
    protected function runConsole($command, Array $options = array()) {
        $options['-e'] = isset($options['-e']) ? $options['-e'] : 'test_sam';
        $options['-q'] = isset($options['-q']) ? $options['-q'] : null;
        $options['-n'] = isset($options['-n']) ? $options['-n'] : true;
        $options = array_merge($options, array('command' => $command));

        $status = $this->application->run(new \Symfony\Component\Console\Input\ArrayInput($options));

        if($status !== 0) {
            throw new \RuntimeException(sprintf('Une erreur est survenue lors d\'execution de la commande %s', $command));
        }

        return true;
    }

    /**
     * Retrieve the named repository.
     *
     * @param type $repositoryName
     * @param string $schema
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository($repositoryName, $schema = 'public') {
        return $this->getEm()->getRepository($repositoryName, $schema);
    }

    /**
     * Recupere gestionaire des entités de doctrine.
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEm() {
        return $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Genere la route en fonction de nom et parametres.
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    protected function generateRoute($route, $params = array()) {
        return $this->client->getContainer()->get('router')->generate($route, $params);
    }

    /**
     * Translates the given message
     *
     * @param string $id The message id
     * @param array $parameters An array of parameters for the message
     * @param string $domain The domain for the message
     * @param string $locale The locale
     * @return string The translated string
     */
    protected function trans($id, array $parameters = array(), $domain = 'messages', $locale = null) {
        return $this->client->getContainer()->get('translator')->trans($id, $parameters, $domain, $locale = null);
    }

    /**
     * Set named service into the container.
     *
     * @param string $serviceIdentifier
     * @param type $service
     * @return type
     */
    protected function setService($serviceIdentifier, $service) {
        return $this->client->getContainer()->set($serviceIdentifier, $service);
    }

    /**
     * Identifie un utilisateur.
     *
     * @param string $userName
     * @param string $userPass
     * @param string $email
     * @param array $roles
     * @param string $sessionAppKey
     * @param string $sessionAppValue
     *
     * @todo Trouver une méthode plus adapté pour pouvoir récuperer
     * l'utilisateur de la bdd à la place de firstname:lastname
     *
     * return void
     */
    protected function logIn($userName, $userPass, $email, array $roles = array(), $sessionAppKey = 'sam_selected_application', $sessionAppValue = 'sam')
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken($userName, $userPass, $firewall, $roles);

        $dbUser = $this->getUserByEmail($email);

        $token->setUser($dbUser);
        $session->set('_security_'.$firewall, serialize($token));
        //TODO: retrieve session key from parameters.yml
        $session->set($sessionAppKey, $sessionAppValue);
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie, true);
        $this->client->getContainer()->get('event_dispatcher')->dispatch(
            AuthenticationEvents::AUTHENTICATION_SUCCESS,
            new AuthenticationEvent($token)
        );
    }

    /**
     * Recupere l'objet correspendant l'utilisateur en cours depuis la session.
     *
     * @return CanalTP\SamEcoreUserManagerBundle\Entity\User
     */
    protected function getCurrentUser()
    {
        if(! (self::$currentUser instanceof SamUser)) {
            $serializedToken = $this->client->getContainer()->get('session')->get('_security_'.$this->firewall);
            $token = unserialize($serializedToken);

            self::$currentUser = $token->getUser();
        }

        return self::$currentUser;
    }

    /**
     * Recupere l'utilisateur par son adresse mail.
     *
     * @param string $email Adresse mail de l'utilisateur.
     * @return \CanalTP\SamEcoreUserManagerBundle\Entity\User
     * @throws \RuntimeException
     */
    protected function getUserByEmail($email)
    {
        $dbUser = $this->getRepository('CanalTPSamEcoreUserManagerBundle:User')->findOneBy(array('email' => $email,));

        if(!($dbUser instanceof SamUser)) {
            throw new \RuntimeException(sprintf('Unable to retrieve SamUser from database by email: %', $email));
        }

        return $dbUser;
    }

    /**
     * Recupere l'utilisateur par son adresse mail.
     *
     * @param string $route route of view
     * @param string $expectedStatusCode status code expected
     * @param string $method Method of request
     * @return Crawler
     * @throws \assertEquals
     */
    protected function doRequestRoute($route, $expectedStatusCode = 200, $method = 'GET')
    {
        $crawler = $this->client->request($method, $route);

        // check response code is expectedStatusCode
        $this->assertEquals(
            $expectedStatusCode,
            $this->client->getResponse()->getStatusCode(),
            'Response status NOK:' . $this->client->getResponse()->getStatusCode() . "\r\n"
        );

        return $crawler;
    }

    protected function getMockedNavitia()
    {
        $navitia = $this->getMockBuilder('CanalTP\MttBundle\Services\Navitia')
            ->setMethods(
                array(
                    'findAllLinesByMode',
                    'getStopPointCalendarsData',
                    'getCalendarStopSchedulesByRoute',
                    'getRouteStopPoints',
                    'getRouteCalendars',
                    'getStopPointTitle',
                    'getStopPointPois',
                    'getStopPoint',
                    'getRouteData'
                )
            )->disableOriginalConstructor()
            ->getMock();

        $navitia->expects($this->any())
            ->method('findAllLinesByMode')
            ->will($this->returnValue(array()));

        $navitia->expects($this->any())
            ->method('getRouteData')
            ->will($this->returnCallback(
                function () {
                    $return = new \stdClass;
                    $return->direction = new \stdClass;
                    $return->direction->embedded_type = 'stop_point';
                    $return->direction->stop_point = new \stdClass;
                    $return->direction->stop_point->name = 'toto';

                    return $return;
                }
            ));

        $navitia->expects($this->any())
            ->method('getRouteStopPoints')
            ->will($this->returnValue(json_decode($this->readNavitiaStub('route_schedules.json'))));

        $navitia->expects($this->any())
            ->method('getStopPointCalendarsData')
            ->will($this->returnValue(json_decode($this->readNavitiaStub('calendars.json'))));

        $navitia->expects($this->any())
            ->method('getStopPointTitle')
            ->will($this->returnValue('stop de test'));

        $navitia->expects($this->any())
            ->method('getStopPoint')
            ->will($this->returnValue(json_decode($this->readNavitiaStub('stop_point.json'))));

        $navitia->expects($this->any())
            ->method('getStopPointPois')
            ->will($this->returnValue(json_decode($this->readNavitiaStub('places_nearby.json'))));

        $navitia->expects($this->any())
            ->method('getCalendarStopSchedulesByRoute')
            ->will($this->returnCallback(
                function () {
                    return json_decode(file_get_contents(dirname(__FILE__) . '/stubs/navitia/stop_schedules.json'));
                }
            ));

        return $navitia;
    }

    protected function getMockedTyr()
    {
        $tyr = $this->getMockBuilder('CanalTP\NmmPortalBundle\Services\NavitiaTokenManager')
            ->setMethods(
                array(
                    'initUser',
                    'initInstanceAndAuthorizations',
                    'deleteToken',
                    'generateToken'
                )
            )
            ->disableOriginalConstructor()
            ->getMock();

        $tyr->expects($this->any())
            ->method('initUser')
            ->will($this->returnValue(null));

        $tyr->expects($this->any())
            ->method('initInstanceAndAuthorizations')
            ->will($this->returnValue(null));

        $tyr->expects($this->any())
            ->method('generateToken')
            ->will($this->returnValue(md5(time())));

        $tyr->expects($this->any())
            ->method('deleteToken')
            ->will($this->returnValue(json_decode($this->readTyrStub('keys.json'))));

        return $tyr;
    }

    protected function readNavitiaStub($filename)
    {
        return file_get_contents($this->navitiaStubsPath . $filename);
    }

    protected function readTyrStub($filename)
    {
        return file_get_contents($this->tyrStubsPath . $filename);
    }
}
