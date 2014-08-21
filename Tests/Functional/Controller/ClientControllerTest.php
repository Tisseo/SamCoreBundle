<?php

namespace CanalTP\SamCoreBundle\Tests\Functional\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use CanalTP\SamCoreBundle\Tests\DataFixtures\ORM\Fixture;

class CustomerControllerTest extends AbstractControllerTest
{
    private $name = 'Divia';

    private function getForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_customer_new');
        $crawler = $this->doRequestRoute($route);

        // Submit form
        $form = $crawler->selectButton('Enregistrer')->form();

        $form['customer[name]'] = $this->name;

        return $form;
    }

    public function testNewForm()
    {
        $form = $this->getForm();
        $crawler = $this->customer->submit($form);

        // Check if when we submit form we are redirected
        $this->assertTrue($this->customer->getResponse() instanceof RedirectResponse);
        $crawler = $this->customer->followRedirect();

        // Check if the value is saved correctly
        $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $this->name . '")')->count());
    }

    public function testEditForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_customer_list');
        $crawler = $this->doRequestRoute($route, 200);
        $text = $crawler->filter('table tbody tr')->first()->filter('td a')->first()->text();
        $link = $crawler->filter('table tbody tr')->first()->filter('td a')->first()->link();
        $crawler2 = $this->doRequestRoute($link->getUri(), 200);

        $this->assertGreaterThan(0, $crawler2->filter('input[value=' . $text . ']')->count());
    }

    public function testUniqueConstraintOnCustomerName()
    {
        $form = $this->getForm();
        $form['customer[name]'] = 'Divia42';

        $crawler = $this->customer->submit($form);
        $this->assertTrue($this->customer->getResponse() instanceof RedirectResponse);
        $crawler = $this->customer->submit($form);
        $this->assertFalse($this->customer->getResponse() instanceof RedirectResponse);
        $this->assertGreaterThan(0, $crawler->filter('div.form-group.has-error')->count());
    }

    public function testEmptyForm()
    {
        // Check if the form is correctly displayed
        $route = $this->generateRoute('sam_customer_new');
        $crawler = $this->doRequestRoute($route);

        $form = $crawler->selectButton('Enregistrer')->form();
        $crawler = $this->customer->submit($form);

        $this->assertFalse($this->customer->getResponse() instanceof RedirectResponse);
        $this->assertGreaterThan(0, $crawler->filter('div.form-group.has-error')->count());
    }
}
