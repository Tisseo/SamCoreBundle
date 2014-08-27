<?php

namespace CanalTP\SamCoreBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use CanalTP\SamCoreBundle\Entity\CustomerApplication;
use CanalTP\SamCoreBundle\Entity\Application;
use CanalTP\SamCoreBundle\Entity\Customer;

class CustomerManager
{
    private $om = null;
    private $repository = null;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repository = $this->om->getRepository('CanalTPSamCoreBundle:Customer');
    }

    public function findAll()
    {
        return ($this->repository->findAll());
    }

    public function find($customerId)
    {
        return empty($customerId) ? null : $this->repository->find($customerId);
    }

    private function syncPerimeters($customer)
    {
        $perimeterRepo = $this->om->getRepository('CanalTPSamCoreBundle:Perimeter');
        $perimeters = $perimeterRepo->findBy(array('customer' => $customer));
        $officialPerimeterIds = array();

        foreach ($customer->getPerimeters() as $perimeter) {
            if ($perimeter->getId() != null) {
                $officialPerimeterIds[] = $perimeter->getId();
            }
        }

        foreach ($perimeters as $perimeter) {
            if (!in_array($perimeter->getId(), $officialPerimeterIds)) {
                $this->om->remove($perimeter);
            }
        }
    }

    public function save($customer)
    {
        if ($customer->getId() != null) {
            $this->syncPerimeters($customer);
        }
        $customer->refreshPerimeters();
        // TODO: UniqueEntity not work in perimeter entity.
        $customer->setPerimeters(array_unique($customer->getPerimeters()->toArray()));
        $this->om->persist($customer);
        $customer->upload();
        $this->om->flush();
    }

    public function findAllToArray()
    {
        return ($this->repository->findAllToArray());
    }
}
