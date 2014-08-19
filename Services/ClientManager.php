<?php

namespace CanalTP\SamCoreBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use CanalTP\SamCoreBundle\Entity\Client;

class ClientManager
{
    private $om = null;
    private $repository = null;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repository = $this->om->getRepository('CanalTPSamCoreBundle:Client');
    }

    public function findAll()
    {
        return ($this->repository->findAll());
    }

    public function find($clientId)
    {
        return empty($clientId) ? null : $this->repository->find($clientId);
    }

    private function syncPerimeters($client)
    {
        $perimeterRepo = $this->om->getRepository('CanalTPSamCoreBundle:Perimeter');
        $perimeters = $perimeterRepo->findBy(array('client' => $client));
        $officialPerimeterIds = array();

        foreach ($client->getPerimeters() as $perimeter) {
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

    public function save($client)
    {
        if ($client->getId() != null) {
            $this->syncPerimeters($client);
        }
        $client->refreshPerimeters();
        // TODO: UniqueEntity not work in perimeter entity.
        $client->setPerimeters(array_unique($client->getPerimeters()->toArray()));
        $this->om->persist($client);
        $client->upload();
        $client->setLastModificationDateTime(new \DateTime());
        $this->om->flush();
    }
}
