<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mode
 *
 * @ORM\Table(name="t_mode_mde")
 * @ORM\Entity(repositoryClass="CanalTP\SamCoreBundle\Entity\ModeRepository")
 */
class Mode
{
    /**
     * @var integer
     *
     * @ORM\Column(name="mde_id", type="string", length=255)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mde_name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="SimMode", mappedBy="mode", cascade={"persist"})
     */
    private $sim_commercial_modes;

    /**
     * Set id
     *
     * @param  integer $id
     * @return Mode
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
     * @return Mode
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sim_commercial_modes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sim_commercial_modes
     *
     * @param  \CanalTP\SamCoreBundle\Entity\SimMode $simCommercialModes
     * @return Mode
     */
    public function addSimCommercialMode(\CanalTP\SamCoreBundle\Entity\SimMode $simCommercialModes)
    {
        $this->sim_commercial_modes[] = $simCommercialModes;

        return $this;
    }

    /**
     * Remove sim_commercial_modes
     *
     * @param \CanalTP\SamCoreBundle\Entity\SimMode $simCommercialModes
     */
    public function removeSimCommercialMode(
        \CanalTP\SamCoreBundle\Entity\SimMode $simCommercialModes
    )
    {
        $this->sim_commercial_modes->removeElement($simCommercialModes);
    }

    /**
     * Get sim_commercial_modes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSimCommercialModes()
    {
        return $this->sim_commercial_modes;
    }
}
