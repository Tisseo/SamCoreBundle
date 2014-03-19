<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table(name="tr_simstatus_sst")
 * @ORM\Entity(repositoryClass="CanalTP\SamCoreBundle\Entity\StatusRepository")
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
     *
     * @ORM\Column(name="sst_id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sst_name", type="string", length=255)
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
