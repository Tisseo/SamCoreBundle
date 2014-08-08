<?php

namespace CanalTP\SamCoreBundle\Form\Model;

/**
 * Description of Client
 *
 * @author kevin
 */
class ClientModel
{
    protected $name;
    protected $navitiaToken;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getNavitiaToken()
    {
        return $this->navitiaToken;
    }
    
    public function setNavitiaToken($navitiaToken)
    {
        $this->navitiaToken = $navitiaToken;
        return $this;
    }
}
