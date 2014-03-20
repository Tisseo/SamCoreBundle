<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SimConfiguration
 *
 * @ORM\Table(name="t_sim_configuration")
 * @ORM\Entity
 */
class SimConfiguration
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $perimetre;

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
     * Set perimetre
     *
     * @param  string           $perimetre
     * @return SimConfiguration
     */
    public function setPerimetre($perimetre)
    {
        $this->perimetre = $perimetre;

        return $this;
    }

    /**
     * Get perimetre
     *
     * @return string
     */
    public function getPerimetre()
    {
        return $this->perimetre;
    }
}
