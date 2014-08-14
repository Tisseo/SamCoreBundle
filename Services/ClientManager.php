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

    public function save($client)
    {
        $client->refreshPerimeters();
        $this->om->persist($client);
        $client->upload();
        $client->setLastModificationDateTime(new \DateTime());
        $this->om->flush();
    }
}
