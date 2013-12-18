<?php

namespace CanalTP\IussaadCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CanalTPIussaadCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
