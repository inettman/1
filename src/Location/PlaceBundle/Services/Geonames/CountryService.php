<?php

namespace Location\PlaceBundle\Services\Geonames;

use GuzzleHttp\ClientInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class CountryService
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var array
     */
    private $geonamesLogins = ['inettman', 'inettman2'];

    const GEONAMES_COUNTRY_HOST = 'http://api.geonames.org/countryInfoJSON';

    /**
     * CountryService constructor.
     * @param ClientInterface $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(ClientInterface $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    public function getCountryByCode($countryCode, $language)
    {
        foreach ($this->geonamesLogins as $row) {
            $options = [
                'query' => [
                    'lang' => $language,
                    'country' => $countryCode,
                    'username' => $row
                ]
            ];

            $geonamesBody = $this->httpClient->get(self::GEONAMES_COUNTRY_HOST, $options)->getBody();
            $result = $this->serializer->deserialize(
                json_encode(json_decode($geonamesBody)->geonames[0]),
                'Location\PlaceBundle\Entity\Geonames\Country',
                'json'
            );

            if (!empty($result)) {
                break;
            }
        }
        return $result;
    }
}