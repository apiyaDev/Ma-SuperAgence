<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;


class PropertySearch
{

    /**
     * @var int
     */
    private $maxPrice;

    /**
     * @var ArrayCollection
     */
    private $option;

    /**
     * @var int
     */
    private $minSurface;


    public function __construct()
    {
        $this->option = new ArrayCollection();
    }

    /**
     * Get the value of maxPrice
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     *
     * @return  self
     */ 
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get the value of minSurface
     */ 
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     *
     * @return  self
     */ 
    public function setMinSurface($minSurface)
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * Get the value of option
     *
     * @return  ArrayCollection
     */ 
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set the value of option
     *
     * @param  ArrayCollection  $option
     *
     * @return  self
     */ 
    public function setOption(ArrayCollection $option)
    {
        $this->option = $option;

        return $this;
    }
}
