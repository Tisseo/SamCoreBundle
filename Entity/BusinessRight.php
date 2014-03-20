<?php

namespace CanalTP\SamCoreBundle\Entity;

/**
 * BusinessRight
 */
class BusinessRight
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $key;

    /**
     * @var Boolean
     */
    private $isPresent;

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string $name
     * @return BusinessRight
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return BusinessRight
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
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
     * Set key
     *
     * @param string $key
     * @return BusinessRight
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get isPresent
     *
     * @return Boolean
     */
    public function getIsPresent()
    {
        return $this->isPresent;
    }

    /**
     * Set isPresent
     *
     * @param string $isPresent
     * @return BusinessRight
     */
    public function setIsPresent($isPresent)
    {
        $this->isPresent = $isPresent;
    
        return $this;
    }
}