<?php

namespace CanalTP\IussaadCoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use CanalTP\IussaadCoreBundle\Entity\Application;

class FixturesApplication extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)       
    {
        //  On crée les rôles par défaut de symfony 2
        $appIussaad = new Application('Iussaad');
        //  On la persiste
        $em->persist($appIussaad);

        $appNMPA = new Application('Navitia Mobility Planner Admin');
        //  On la persiste
        $em->persist($appNMPA);

        $appTimetable = new Application('TimeTable');
        //  On la persiste
        $em->persist($appTimetable);

        $appMatrix = new Application('Matrix');
        //  On la persiste
        $em->persist($appMatrix);
                
        //  On déclenche l'enregistrement
        $em->flush();
        $this->addReference('app-iussaad', $appIussaad);
        $this->addReference('app-nmpa', $appNMPA);
        $this->addReference('app-timetable', $appTimetable);
        $this->addReference('app-matrix', $appMatrix);
    }
    
     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
