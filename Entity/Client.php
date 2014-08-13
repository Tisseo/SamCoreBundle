<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Client
 */
class Client
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var file
     */
    private $file;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @var string
     */
    private $nameCanonical;

    /**
     * @var boolean
     */
    private $locked;

    /**
     * @var \DateTime
     */
    private $creationDateTime;

    /**
     * @var \DateTime
     */
    private $lastModificationDateTime;

    /**
     * @var string
     */
    private $navitiaToken;

    /**
     *
     * @var Application
     */
    private $applications = array();

    private $users = array();


    public function __construct()
    {
        $this->creationDateTime = new \DateTime();
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
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setNameCanonical($name);

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
     * Set logoPath
     *
     * @param string $logoPath
     * @return Client
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set nameCanonical
     *
     * @param string $nameCanonical
     * @return Client
     */
    private function setNameCanonical($name)
    {
        $slug = new \CanalTP\SamCoreBundle\Slugify();

        $this->nameCanonical = $slug->slugify($name);

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
     * Set locked
     *
     * @param boolean $locked
     * @return Client
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set creationDateTime
     *
     * @param \DateTime $creationDateTime
     * @return Client
     */
    public function setCreationDateTime($creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    /**
     * Get creationDateTime
     *
     * @return \DateTime
     */
    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    /**
     * Set lastModificationDateTime
     *
     * @param \DateTime $lastModificationDateTime
     * @return Client
     */
    public function setLastModificationDateTime($lastModificationDateTime)
    {
        $this->lastModificationDateTime = $lastModificationDateTime;

        return $this;
    }

    /**
     * Get lastModificationDateTime
     *
     * @return \DateTime
     */
    public function getLastModificationDateTime()
    {
        return $this->lastModificationDateTime;
    }

    public function setNavitiaToken($navitiaToken)
    {
        $this->navitiaToken = $navitiaToken;

        return $this;
    }

    public function getNavitiaToken()
    {
        return $this->navitiaToken;
    }

    public function setApplications($applications)
    {
        $this->applications = $applications;

        return $this;
    }

    public function addApplication($application)
    {
        $this->applications[] = $application;

        return $this;
    }

    public function removeApplication($application)
    {
        foreach ($$this->applications as $key => $app) {
            if ($app->getId() == $application->getId()) {
                unset($this->applications[$key]);
                break ;
            }
        }

        return $this;
    }

    public function getApplications()
    {
        return $this->applications;
    }

    public function addUser($user)
    {
        $this->users[] = $user;

        return $this;
    }

    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set File
     *
     * @return LayoutConfig
     */
    public function getFile()
    {
        return ($this->file);
    }

    /**
     * Set file
     *
     * @return LayoutConfig
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return ($this);
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $file = $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );
        $fileName = $this->getId() . '.' . $file->getExtension();
        $file->move(
            $this->getUploadRootDir(),
            $fileName
        );

        $this->logoPath = $fileName;
        $this->file = null;
    }

    public function getAbsoluteLogoPath()
    {
        return null === $this->logoPath
            ? null
            : $this->getUploadRootDir().'/'.$this->logoPath;
    }

    public function getWebLogoPath()
    {
        return null === $this->logoPath
            ? null
            : $this->getUploadDir().'/'.$this->logoPath;
    }

    private function getUploadRootDir()
    {
        return __DIR__.'/../../../../web' . $this->getUploadDir();
    }

    private function getUploadDir()
    {
        return '/uploads/clients/logos/';
    }
}
