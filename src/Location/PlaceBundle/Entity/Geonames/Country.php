<?php

namespace Location\PlaceBundle\Entity\Geonames;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\SerializedName;

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    dirname(__DIR__).'/vendor/jms/serializer/src'
);

class Country
{
    /**
     * @Type("string")
     * @SerializedName("currencyCode")
     */
    private $currencyCode;

    /**
     * @Type("integer")
     */
    private $population;

    /**
     * @Type("double")
     * @SerializedName("areaInSqKm")
     */
    private $areaInSqKm;

    /**
     * @Type("string")
     * @SerializedName("isoNumeric")
     */
    private $isoNumeric;

    /**
     * @Type("string")
     */
    private $languages;

    /**
     * @Type("string")
     * @SerializedName("continentName")
     */
    private $continentName;

    /**
     * @Type("integer")
     * @SerializedName("geonameId")
     */
    private $geonameId;

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param mixed $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return mixed
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param mixed $population
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    }

    /**
     * @return mixed
     */
    public function getAreaInSqKm()
    {
        return $this->areaInSqKm;
    }

    /**
     * @param mixed $areaInSqKm
     */
    public function setAreaInSqKm($areaInSqKm)
    {
        $this->areaInSqKm = $areaInSqKm;
    }

    /**
     * @return mixed
     */
    public function getIsoNumeric()
    {
        return $this->isoNumeric;
    }

    /**
     * @param mixed $isoNumeric
     */
    public function setIsoNumeric($isoNumeric)
    {
        $this->isoNumeric = $isoNumeric;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param mixed $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }

    /**
     * @return mixed
     */
    public function getContinentName()
    {
        return $this->continentName;
    }

    /**
     * @param mixed $continentName
     */
    public function setContinentName($continentName)
    {
        $this->continentName = $continentName;
    }

    /**
     * @return mixed
     */
    public function getGeonameId()
    {
        return $this->geonameId;
    }

    /**
     * @param mixed $geonameId
     */
    public function setGeonameId($geonameId)
    {
        $this->geonameId = $geonameId;
    }


}