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
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="perimetre", type="string", length=255)
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
