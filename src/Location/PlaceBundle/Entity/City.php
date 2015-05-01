<?php

namespace Location\PlaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Location\PlaceBundle\Entity\CityRepository")
 */
class City
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
     * @ORM\ManyToOne(targetEntity="District", inversedBy="cities")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    protected $district;
    
    /**
     * @ORM\OneToMany(targetEntity="Place", mappedBy="city")
     */
    protected $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * @return City
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
     * Set district
     *
     * @param \Location\PlaceBundle\Entity\District $district
     * @return City
     */
    public function setDistrict(\Location\PlaceBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \Location\PlaceBundle\Entity\District 
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Add places
     *
     * @param \Location\PlaceBundle\Entity\Place $places
     * @return City
     */
    public function addPlace(\Location\PlaceBundle\Entity\Place $places)
    {
        $this->places[] = $places;

        return $this;
    }

    /**
     * Remove places
     *
     * @param \Location\PlaceBundle\Entity\Place $places
     */
    public function removePlace(\Location\PlaceBundle\Entity\Place $places)
    {
        $this->places->removeElement($places);
    }

    /**
     * Get places
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlaces()
    {
        return $this->places;
    }
}
