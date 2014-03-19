<?php

/**
 * Description of class Sim
 *
 * @author akambi
 */

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="tj_simmode_smd")
 * @ORM\HasLifecycleCallbacks()
 */
class SimMode
{
    /**
    * @ORM\Id
    * @ORM\Column(name="smd_id", type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * @ORM\Column(name="smd_name", type="string", length=255)
     */
    protected $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="smd_available", type="boolean")
     */
    private $available;

    /**
     * @var boolean
     *
     * @ORM\Column(name="smd_visible", type="boolean")
     */
    private $visible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="smd_includeByDefault", type="boolean")
     */
    private $includeByDefault;

    /**
     * @var \Entity\Sim $sim
     *
     * @ORM\ManyToOne(targetEntity="Sim")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sim_id", referencedColumnName="sim_id")
     * })
     */
    protected $sim;

    /**
     * @ORM\ManyToOne(targetEntity="Mode")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="mde_id", referencedColumnName="mde_id")
     * })
     *
     */
    protected $mode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sim_createdate", type="datetime", nullable=false)
     */
    protected $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sim_updatedate", type="datetime", nullable=true)
     */
    protected $updateDate;

    protected $picto;
    
    /**
     * Constructor
     */
    public function __construct()
    {

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

    public function getAbsolutePath()
    {
        return null === $this->picto ? null : $this->getUploadRootDir().'/'.$this->picto;
    }

    public function getWebPath()
    {
        return null === $this->picto ? null : $this->getUploadDir().'/'.$this->picto;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/modepicto';
    }

    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {
//        if (null === $this->pictoFile) {
//            return;
//        }
//
//        // s'il y a une erreur lors du déplacement du fichier, une exception
//        // va automatiquement être lancée par la méthode move(). Cela va empêcher
//        // proprement l'entité d'être persistée dans la base de données si
//        // erreur il y a
//        $this->pictoFile->move($this->getUploadRootDir(), $this->picto);
//
//        unset($this->pictoFile);
//
//        if (null !== $this->oldFile) {
//            unlink($this->oldFile);
//        }
//        unset($this->oldFile);
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
    {
//        if ($file = $this->getAbsolutePath()) {
//            unlink($file);
//        }
    }

//    private function preUpload()
//    {
//        // PreUpload
//        if (null !== $this->pictoFile) {
//            // On conserve l'ancien logo pour pouvoir le supprimer
//            // si le nouveau logo a bien été persisté
//            $this->oldFile = $this->getAbsolutePath();
//            // faites ce que vous voulez pour générer un nom unique
//            $this->picto = sha1(uniqid(mt_rand(), true)).'.'.$this->pictoFile->guessExtension();
//        }
//        $this->updated_at = new \DateTime();
//    }

    /**
    * Appeler avant la persistance d'un object en base de donnée
    * @ORM\PrePersist()
    */
    public function onPrePersist()
    {
        $this->setCreateDate(new \DateTime('now'));
        if ($this->getName() == null) {
            $this->setName($this->getMode()->getName());
        }
//        $this->preUpload();
    }

    /**
     * Appeler avant la mise à jour d'un objet en base de donnée
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdateDate(new \DateTime('now'));
        if ($this->getName() == null) {
            $this->setName($this->getMode()->getName());
        }
//        $this->preUpload();
    }

    /**
     * Set picto
     *
     * @param  string  $picto
     * @return SimMode
     */
    public function setPicto($picto)
    {
        $this->picto = $picto;

        return $this;
    }

    /**
     * Get picto
     *
     * @return string
     */
    public function getPicto()
    {
        return $this->picto;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return SimMode
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
     * Get nameCanonical
     *
     * @return string
     */
    public function getNameCanonical()
    {
        return $this->name;
    }
    
    /**
     * Set available
     *
     * @param  boolean $available
     * @return Mode
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set visible
     *
     * @param  boolean $visible
     * @return Mode
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set includeByDefault
     *
     * @param  boolean $includeByDefault
     * @return Mode
     */
    public function setIncludeByDefault($includeByDefault)
    {
        $this->includeByDefault = $includeByDefault;

        return $this;
    }

    /**
     * Get includeByDefault
     *
     * @return boolean
     */
    public function getIncludeByDefault()
    {
        return $this->includeByDefault;
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
     * Set sim
     *
     * @param  \CanalTP\SamCoreBundle\Entity\Sim $sim
     * @return SimMode
     */
    public function setSim(\CanalTP\SamCoreBundle\Entity\Sim $sim = null)
    {
        $this->sim = $sim;

        return $this;
    }

    /**
     * Get sim
     *
     * @return \CanalTP\SamCoreBundle\Entity\Sim
     */
    public function getSim()
    {
        return $this->sim;
    }

    /**
     * Set mode
     *
     * @param  \CanalTP\SamCoreBundle\Entity\Mode $mode
     * @return SimMode
     */
    public function setMode(\CanalTP\SamCoreBundle\Entity\Mode $mode = null)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return \CanalTP\SamCoreBundle\Entity\Mode
     */
    public function getMode()
    {
        return $this->mode;
    }
}
