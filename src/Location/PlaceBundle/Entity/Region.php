<?php

namespace Location\PlaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Region
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Location\PlaceBundle\Entity\RegionRepository")
 */
class Region
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
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="regions")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    protected $country;
    
    /**
     * @ORM\OneToMany(targetEntity="District", mappedBy="region")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $districts;

    public function __construct()
    {
        $this->districts = new ArrayCollection();
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * Set country
     *
     * @param \Location\PlaceBundle\Entity\Country $country
     * @return Region
     */
    public function setCountry(\Location\PlaceBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Location\PlaceBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add districts
     *
     * @param \Location\PlaceBundle\Entity\District $districts
     * @return Region
     */
    public function addDistrict(\Location\PlaceBundle\Entity\District $districts)
    {
        $this->districts[] = $districts;

        return $this;
    }

    /**
     * Remove districts
     *
     * @param \Location\PlaceBundle\Entity\District $districts
     */
    public function removeDistrict(\Location\PlaceBundle\Entity\District $districts)
    {
        $this->districts->removeElement($districts);
    }

    /**
     * Get districts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDistricts()
    {
        return $this->districts;
    }
}
