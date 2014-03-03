<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use CanalTP\MediaManagerBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;

class Network extends Media
{

    private $lines;

    public function __construct()
    {
        parent::__construct();
        $this->lines = new ArrayCollection();
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function setLines(ArrayCollection $lines)
    {
        $this->lines = $lines;

        return $this;
    }
}
