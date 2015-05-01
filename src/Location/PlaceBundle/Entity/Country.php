<?php

namespace Location\PlaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Country
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Location\PlaceBundle\Entity\CountryRepository")
 */
class Country
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=250)
     */
    protected $address;
    
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $google_place_id;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lat;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lng;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lat_n;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lat_s;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lng_w;
    
    /**
     * @ORM\Column(type="decimal", scale=6)
     */
    protected $lng_e;
    
    /**
     * @ORM\OneToMany(targetEntity="Region", mappedBy="country")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * @return Country
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
     * Set address
     *
     * @param string $address
     * @return Country
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set google_place_id
     *
     * @param string $googlePlaceId
     * @return Country
     */
    public function setGooglePlaceId($googlePlaceId)
    {
        $this->google_place_id = $googlePlaceId;

        return $this;
    }

    /**
     * Get google_place_id
     *
     * @return string 
     */
    public function getGooglePlaceId()
    {
        return $this->google_place_id;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Country
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return Country
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lat_n
     *
     * @param string $latN
     * @return Country
     */
    public function setLatN($latN)
    {
        $this->lat_n = $latN;

        return $this;
    }

    /**
     * Get lat_n
     *
     * @return string 
     */
    public function getLatN()
    {
        return $this->lat_n;
    }

    /**
     * Set lat_s
     *
     * @param string $latS
     * @return Country
     */
    public function setLatS($latS)
    {
        $this->lat_s = $latS;

        return $this;
    }

    /**
     * Get lat_s
     *
     * @return string 
     */
    public function getLatS()
    {
        return $this->lat_s;
    }

    /**
     * Set lng_w
     *
     * @param string $lngW
     * @return Country
     */
    public function setLngW($lngW)
    {
        $this->lng_w = $lngW;

        return $this;
    }

    /**
     * Get lng_w
     *
     * @return string 
     */
    public function getLngW()
    {
        return $this->lng_w;
    }

    /**
     * Set lng_e
     *
     * @param string $lngE
     * @return Country
     */
    public function setLngE($lngE)
    {
        $this->lng_e = $lngE;

        return $this;
    }

    /**
     * Get lng_e
     *
     * @return string 
     */
    public function getLngE()
    {
        return $this->lng_e;
    }

    /**
     * Add regions
     *
     * @param \Location\PlaceBundle\Entity\Region $regions
     * @return Country
     */
    public function addRegion(\Location\PlaceBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;

        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Location\PlaceBundle\Entity\Region $regions
     */
    public function removeRegion(\Location\PlaceBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
