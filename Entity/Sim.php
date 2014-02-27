<?php

/**
 * Description of class Sim
 *
 * @author akambi
 */

namespace CanalTP\IussaadCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 */
class Sim
{
    /**
     * @var integer
    */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nameCanonical;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var Status $status
     */
    protected $status;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var \DateTime
     */
    private $updateDate;

    /**
     * @var array
     */
    protected $networks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $sim_commercial_modes;

    protected $logo;
    protected $networkObjects;

    protected $massUpload;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->massUpload = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sim_commercial_modes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setNameCanonical($name);
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
     * Appeler avant la persistance d'un object en base de donnée
     */
    public function onPrePersist()
    {
        $this->setCreateDate(new \DateTime('now'));
    }

    /**
     * Appeler avant la mise à jour d'un objet en base de donnée
     */
    public function onPreUpdate()
    {
        $this->setUpdateDate(new \DateTime('now'));
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return Group
     */
    public function setName($name)
    {
        $this->setNameCanonical($name);

        return parent::setName($name);
    }

    /**
     * Set nameCanonical
     *
     * @param  string $name
     * @return Group
     */
    public function setNameCanonical($name)
    {
        $this->nameCanonical = strtolower($name);

        return $this;
    }

    /**
     * Get nameCanonical
     *
     * @return string
     */
    public function getNameCanonical()
    {
        return $this->nameCanonical;
    }

    /**
     * Set Url
     *
     * @param  string $url
     * @return Group
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Set createDate
     *
     * @param  \DateTime $createDate
     * @return Sim
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     *
     * @param  \DateTime $updateDate
     * @return Sim
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set status
     *
     * @param  string $status
     * @return Sim
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set networks
     *
     * @param  array $networks
     * @return Sim
     */
    public function setNetworks($networks)
    {
        $this->networks = $networks;

        return $this;
    }

    /**
     * Get networks
     *
     * @return array
     */
    public function getNetworks()
    {
        return $this->networks;
    }

    /**
     * Get networkObjects
     *
     * @return ArrayCollection
     */
    public function getNetworkObjects()
    {
        return $this->networkObjects;
    }

    /**
     * Set NetworkObjects
     *
     * @param  ArrayCollection $networkObjects
     * @return Sim
     */
    public function setNetworkObjects(ArrayCollection $networkObjects)
    {
        $this->networkObjects = $networkObjects;

        return $this;
    }

    /**
     * Get Logo
     *
     * @return String
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set Logo
     *
     * @param  String $logo
     * @return Sim
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Add sim_commercial_modes
     *
     * @param  \CanalTP\IussaadCoreBundle\Entity\SimMode $simCommercialModes
     * @return Sim
     */
    public function addSimCommercialMode(\CanalTP\IussaadCoreBundle\Entity\SimMode $simCommercialModes)
    {
        $this->sim_commercial_modes[] = $simCommercialModes;

        return $this;
    }

    /**
     * Remove sim_commercial_modes
     *
     * @param \CanalTP\IussaadCoreBundle\Entity\SimMode $simCommercialModes
     */
    public function removeSimCommercialMode(
        \CanalTP\IussaadCoreBundle\Entity\SimMode $simCommercialModes
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
    
    /**
     * Get massUpload
     *
     * @return $massUpload
     */
    public function getMassUpload()
    {
        return $this->massUpload;
    }

    /**
     * Set massUpload
     *
     * @return Sim
     */
    public function setMassUpload($massUpload)
    {

        $this->massUpload = $massUpload;

        return $this;
    }
}
