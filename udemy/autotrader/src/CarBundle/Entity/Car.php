<?php

namespace CarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="CarBundle\Repository\CarRepository")
 */
class Car
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="CarBundle\Entity\Model", inversedBy="cars")
     */
    private $model;

    /**
     * @var Make
     *
     * @ORM\ManyToOne(targetEntity="CarBundle\Entity\Make", inversedBy="cars")
     */
    private $make;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var bool
     *
     * @ORM\Column(name="navigation", type="boolean")
     */
    private $navigation;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return bool
     */
    public function isNavigation(): ?bool
    {
        return $this->navigation;
    }

    /**
     * @param bool $navigation
     */
    public function setNavigation(bool $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * Get navigation
     *
     * @return boolean
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Set model
     *
     * @param \CarBundle\Entity\Make $model
     *
     * @return Car
     */
    public function setModel(\CarBundle\Entity\Make $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \CarBundle\Entity\Make
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set make
     *
     * @param \CarBundle\Entity\Make $make
     *
     * @return Car
     */
    public function setMake(\CarBundle\Entity\Make $make = null)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return \CarBundle\Entity\Make
     */
    public function getMake()
    {
        return $this->make;
    }
}
