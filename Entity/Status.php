<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 */
class Status
{

    const NETWORK_CONFIGURATION = 1;
    const LOGO_CONFIGURATION = 2;
    const PICTO_CONFIGURATION = 3;
    const ROUTE_AN_MODE_CONFIGURATION = 4;
    const DONE = 5;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Set id
     *
     * @param  integer $id
     * @return Status
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set name
     *
     * @param  string $name
     * @return Status
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
