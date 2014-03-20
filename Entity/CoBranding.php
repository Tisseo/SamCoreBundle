<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoBranding
 */
class CoBranding
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var text
     */
    private $address;

    /**
     * @var text
     */
    private $motivation;

    /**
     * @var string
     */
    private $domaine;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $job;

    /**
     * @var string
     */
    private $key;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var \Entity\Sim $sim
     */
    protected $sim;

    /**
     * Appeler avant la persistance d'un object en base de donnée
     */
    public function onPrePersist()
    {
        $this->setStatus(false);
        $this->setCreatedAt(new \DateTime('now'));
    }

    /**
     * Appeler avant la mise à jour d'un objet en base de donnée
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new \DateTime('now'));
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
     * Set firstname
     *
     * @param  string     $firstname
     * @return CoBranding
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param  string     $lastname
     * @return CoBranding
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set address
     *
     * @param  text       $address
     * @return CoBranding
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return text
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set motivation
     *
     * @param  text       $motivation
     * @return CoBranding
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * Get motivation
     *
     * @return text
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set domaine
     *
     * @param  string     $domaine
     * @return CoBranding
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get domaine
     *
     * @return string
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set email
     *
     * @param  string     $email
     * @return CoBranding
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set job
     *
     * @param  string     $job
     * @return CoBranding
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set key
     *
     * @param  string     $key
     * @return CoBranding
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime  $createdAt
     * @return CoBranding
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime  $updatedAt
     * @return CoBranding
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set status
     *
     * @param  boolean    $status
     * @return CoBranding
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set company
     *
     * @param  string     $company
     * @return CoBranding
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set sim
     *
     * @param  \CanalTP\SamCoreBundle\Entity\Sim $sim
     * @return CoBranding
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
}
