<?php

namespace CanalTP\SamCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Customer
 */
class Customer extends AbstractEntity implements CustomerInterface
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
     * @var file
     */
    protected $file;

    /**
     * @var string
     */
    protected $logoPath;

    /**
     * @var string
     */
    protected $nameCanonical;

    /**
     * @var boolean
     */
    private $locked;

    /**
     *
     * @var Application
     */
    protected $applications;

    protected $users;

    protected $perimeters;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->perimeters = new ArrayCollection();
        $this->locked = false;
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
     */
    protected function setNameCanonical($name)
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
     * @return Customer
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

    public function setApplications($applications)
    {
        $this->applications = $applications;

        return $this;
    }

    public function addApplication($application)
    {
        $this->applications->add($application);

        return $this;
    }

    public function removeApplication($application)
    {
        $this->applications->removeElement($application);

        return $this;
    }

    public function getApplications()
    {
        return $this->applications;
    }

    public function getActiveCustomerApplications()
    {
        return (
            $this->getApplications()->filter(
                function($customerApplication) {
                   return ($customerApplication->getIsActive());
                }
            )
        );
    }

    public function addUser($user)
    {
        $this->users->add($user);

        return $this;
    }

    public function removeUser($user)
    {
        $this->users->removeElement($user);

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

    public function addPerimeter($perimeter)
    {
        $this->perimeters->add($perimeter);
        $perimeter->setCustomer($this);

        return $this;
    }

    public function removePerimeter($perimeter)
    {
        $this->perimeters->removeElement($perimeter);

        return $this;
    }

    public function setPerimeters($perimeters)
    {
        $this->perimeters = $perimeters;
        foreach ($perimeters as $perimeter) {
            $perimeter->setCustomer($this);
        }

        return $this;
    }

    public function refreshPerimeters()
    {
        foreach ($this->perimeters as $perimeter) {
            $perimeter->setCustomer($this);
        }

        return $this;
    }

    public function getPerimeters()
    {
        return $this->perimeters;
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

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web' . $this->getUploadDir();
    }

    private function getUploadDir()
    {
        return '/uploads/customers/logos/';
    }
}
