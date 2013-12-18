<?php

namespace CanalTP\IussaadCoreBundle\Entity;

use CanalTP\IussaadCoreBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;

class Network extends Media
{

    private $lines;

    public function __construct(
        $parentType = null,
        $parentId = null,
        $childrenType = '',
        $childrenId = ''
    )
    {
        parent::__construct(
            $parentType,
            $parentId,
            $childrenType,
            $childrenId
        );
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
