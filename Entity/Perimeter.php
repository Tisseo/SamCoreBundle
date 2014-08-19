<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perimeter
 */
class Perimeter
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $externalCoverageId;

    /**
     * @var string
     */
    private $externalNetworkId;

    private $client;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set externalCoverageId
     *
     * @param string $externalCoverageId
     * @return Perimeter
     */
    public function setExternalCoverageId($externalCoverageId)
    {
        $this->externalCoverageId = $externalCoverageId;

        return $this;
    }

    /**
     * Get externalCoverageId
     *
     * @return string
     */
    public function getExternalCoverageId()
    {
        return $this->externalCoverageId;
    }

    /**
     * Set externalNetworkId
     *
     * @param string $externalNetworkId
     * @return Perimeter
     */
    public function setExternalNetworkId($externalNetworkId)
    {
        $this->externalNetworkId = $externalNetworkId;

        return $this;
    }

    /**
     * Get externalNetworkId
     *
     * @return string
     */
    public function getExternalNetworkId()
    {
        return $this->externalNetworkId;
    }

    /**
     * Set client
     *
     * @param string $client
     * @return Perimeter
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    public function __toString()
    {
        return ($this->getId() . ' ' . $this->getExternalCoverageId() . ' ' . $this->getExternalNetworkId());
    }
}
