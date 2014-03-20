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
        //  On crée les rôles par défaut de symfony 2
        $appSam = new Application('Sam');
        //  On la persiste
        $em->persist($appSam);

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
        $this->addReference('app-sam', $appSam);
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
