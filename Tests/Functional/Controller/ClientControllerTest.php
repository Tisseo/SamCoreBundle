<?php

namespace CanalTP\SamCoreBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use CanalTP\SamCoreBundle\Tests\DataFixtures\ORM\Fixture;

class ClientControllerTest extends AbstractControllerTest
{
    private $name = 'Divia';

    private function getForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_client_new');
        $crawler = $this->doRequestRoute($route);

        // Submit form
        $form = $crawler->selectButton('Enregistrer')->form();

        $form['client[name]'] = $this->name;

        return $form;
    }

    public function testNewForm()
    {
        $form = $this->getForm();
        $crawler = $this->client->submit($form);

        // Check if when we submit form we are redirected
        $this->assertTrue($this->client->getResponse() instanceof RedirectResponse);
        $crawler = $this->client->followRedirect();

        // Check if the value is saved correctly
        $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $this->name . '")')->count());
    }

    public function testEditForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_client_list');
        $crawler = $this->doRequestRoute($route, 200);
        $link = $crawler->filter('table tbody tr')->first()->filter('td a')->first()->link();

        $crawler2 = $this->doRequestRoute($link->getUri(), 200);

        $this->assertGreaterThan(0, $crawler2->filter('input[value=' . $this->name . ']')->count());
    }

    public function testEmptyForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_client_new');
        $crawler = $this->doRequestRoute($route);

        $form = $crawler->selectButton('Enregistrer')->form();
        $crawler = $this->client->submit($form);

        $this->assertFalse($this->client->getResponse() instanceof RedirectResponse);
        $this->assertGreaterThan(0, $crawler->filter('div.form-group.has-error')->count());
    }

    // TODO : testUniqueConstraintOnClientName
    // public function testUniqueConstraintOnClientName()
    // {
    //     $form = $this->getForm();
    //     $form['client[name]'] = 'Divia42';

    //     $crawler = $this->client->submit($form);
    //     $this->assertTrue($this->client->getResponse() instanceof RedirectResponse);
    //     $crawler = $this->client->submit($form);
    //     $this->assertFalse($this->client->getResponse() instanceof RedirectResponse);
    //     $this->assertGreaterThan(0, $crawler->filter('div.form-group.has-error')->count());
    // }
}
