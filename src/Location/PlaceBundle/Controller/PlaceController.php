<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\Map;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Places\Autocomplete;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use Ivory\GoogleMap\Helper\Places\AutocompleteHelper;
use Ivory\GoogleMap\Events\Event;
use Location\PlaceBundle\Entity\Place;
use Location\PlaceBundle\Entity\City;
use Location\PlaceBundle\Entity\District;
use Location\PlaceBundle\Entity\Region;
use Location\PlaceBundle\Entity\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlaceController extends Controller
{
    public function mapAction($id)
    {   
        $place = $this->getDoctrine()
            ->getRepository('LocationPlaceBundle:Place')
            ->find($id);

        if (!$place) {
            throw $this->createNotFoundException(
                'No place found'
            );
        }

        $translater = $this->get('translator');
        
        $city = $place->getCity();
        
        $district = $city->getDistrict();
        
        $region = $district->getRegion();
        
        $country = $region->getCountry();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        if($district->getGooglePlaceId() == $city->getGooglePlaceId()) {
            $breadcrumbs->addRouteItem($region->getName(), 'location_region_map', array('id'=>$region->getId()));
        } else {
            $breadcrumbs->addRouteItem($district->getName(), 'location_district_map', array('id'=>$district->getId()));
        }
        $breadcrumbs->addRouteItem($city->getName(), 'location_city_map', array('id'=>$city->getId()));
        
        $title = $place->getName().' '.$translater->trans('on_map');
        
        $district_name = $city->getGooglePlaceId()!=$district->getGooglePlaceId()?$district->getName().', ':'';
        
        $description = $city->getName().', '.$district_name.$region->getName().', '.$country->getName();
        
        $map = $this->get('ivory_google_map.map');
        
        $map->setCenter($place->getLat(), $place->getLng(), true);
        
        $map->setMapOption('zoom', 16);
        
        $marker = new Marker();
        
        $marker->setPosition($place->getLat(), $place->getLng(), true);
        
        $map->addMarker($marker);
        
        return $this->render('LocationPlaceBundle:Place:map.html.twig', array('map' => $map, 'title'=>$title, 'description'=>$description,  'place'=>$place));
    }
    
    public function searchAction($map)
    {   
        $translater = $this->get('translator');

        $map_var = $map->getJavascriptVariable();

        $autocomplete = new Autocomplete();
        
        $autocomplete->setInputAttributes(['class' => 'form-control input-lg', 'placeholder' => $translater->trans('search placeholder')]);
        
        $autocomplete->setLanguage($this->container->getParameter('locale'));

        $autocomplete_var = $autocomplete->getJavascriptVariable();

        $autocompleteHelper = new AutocompleteHelper();
        
        $autocomplete_view = array(
            'html' => $autocompleteHelper->renderHtmlContainer($autocomplete),
            'js'   => $autocompleteHelper->renderJavascripts($autocomplete) 
        ); 
        
        $vars = array();
        $vars['map'] = $map_var;
        $vars['autocomplete'] = $autocomplete_var;
        
        $autocomplete_types[] = array('title' => $translater->trans('all'), 'value' => '');
        $autocomplete_types[] = array('title' => $translater->trans('address'), 'value' => 'address');
        $autocomplete_types[] = array('title' => $translater->trans('establishment'), 'value' => 'establishment');

        return $this->render('LocationPlaceBundle:Place:search.html.twig', array('map' => $map, 'autocomplete_view' => $autocomplete_view, 'vars' =>$vars, 'autocomplete_types' => $autocomplete_types));
    }
    
    public function addAction()
    {
        $place_arr = json_decode($_POST['place'], TRUE);
        $location_arr = json_decode($_POST['location'], TRUE);
        
        $translater = $this->get('translator');
        
        $city_arr = array();
        $district_arr = array();
        $region_arr = array();
        $country_arr = array();
        
        $result = '';

        foreach($location_arr as $location){
            
           if(in_array('locality', $location['types'])){
               $city_arr = $location;
           }
           
           if(in_array('administrative_area_level_2', $location['types'])){
               $district_arr = $location;
           }
           
           if(in_array('administrative_area_level_1', $location['types'])){
               $region_arr = $location;
           }
           
           if(in_array('country', $location['types'])){
               $country_arr = $location;
           }
           
        }

        $em = $this->getDoctrine()->getManager();
        
        if ($country_arr && $country_arr['geometry']['location']) {

            $country = $this->getDoctrine()->getRepository('LocationPlaceBundle:Country')->findOneBy(array('google_place_id'=>$country_arr['place_id']));

            if (!$country) {
                $country = new Country();
                $country->setName($country_arr['address_components'][0]['long_name']);
                $country->setAddress($country_arr['address_components'][0]['short_name']);
                $country->setGooglePlaceId($country_arr['place_id']);
                $country->setLat(current($country_arr['geometry']['location']));
                $country->setLng(end($country_arr['geometry']['location']));

                $country->setLatS($country_arr['geometry']['viewport']['south']);
                $country->setLatN($country_arr['geometry']['viewport']['north']);
                $country->setLngW($country_arr['geometry']['viewport']['west']);
                $country->setLngE($country_arr['geometry']['viewport']['east']);

                $geonamesCountry = $this->container
                    ->get('geonames.country.service')
                    ->getCountryByCode(
                        $country_arr['address_components'][0]['short_name'],
                        $this->container->getParameter('locale')
                    );
                if (!empty($geonamesCountry)) {
                    $country->setCurrencyCode($geonamesCountry->getCurrencyCode());
                    $country->setPopulation($geonamesCountry->getPopulation());
                    $country->setArea($geonamesCountry->getAreaInSqKm());
                    $country->setIsoCode($geonamesCountry->getIsoNumeric());
                }

                $em->persist($country);
                $em->flush();
            }

            if ($place_arr['place_id'] == $country_arr['place_id']) {
                $link = array(
                    'name' => $country->getName(),
                    'href' => $this->generateUrl('location_country_map', array('id' => $country->getId()))
                );
                $result = $this->renderView('LocationPlaceBundle:Map:info.html.twig', array('link' => $link));
            }
            
            
        }
        
        if($region_arr && isset($country) && $region_arr['geometry']['location']){

            $region = $this->getDoctrine()->getRepository('LocationPlaceBundle:Region')->findOneBy(array('google_place_id'=>$region_arr['place_id']));
            
            if(!$region){
                $region = new Region();
            }

            $region->setName($region_arr['address_components'][0]['long_name']);
            $region->setAddress($region_arr['formatted_address']);
            $region->setGooglePlaceId($region_arr['place_id']);
            $region->setLat(current($region_arr['geometry']['location']));
            $region->setLng(end($region_arr['geometry']['location']));

            $region->setLatS($region_arr['geometry']['viewport']['south']);
            $region->setLatN($region_arr['geometry']['viewport']['north']);
            $region->setLngW($region_arr['geometry']['viewport']['west']);
            $region->setLngE($region_arr['geometry']['viewport']['east']);
            
            $region->setCountry($country);
            
            $em->persist($region);
            $em->flush();
            
            if($place_arr['place_id'] == $region_arr['place_id']){
                $link = array(
                    'name' => $region->getName(),
                    'href' => $this->generateUrl('location_region_map', array('id' => $region->getId()))
                );
                $result = $this->renderView('LocationPlaceBundle:Map:info.html.twig', array('link' => $link));
            }
            
        }
        
        if(isset($region)) {
            
            if($district_arr && $district_arr['geometry']['location']) {
                $district = $this->getDoctrine()->getRepository('LocationPlaceBundle:District')->findOneBy(array('google_place_id'=>$district_arr['place_id']));

                if(!$district){
                    $district = new District();
                }

                $district->setName($district_arr['address_components'][0]['long_name']);
                $district->setAddress($district_arr['formatted_address']);
                $district->setGooglePlaceId($district_arr['place_id']);
                $district->setLat(current($district_arr['geometry']['location']));
                $district->setLng(end($district_arr['geometry']['location']));

                $district->setLatS($district_arr['geometry']['viewport']['south']);
                $district->setLatN($district_arr['geometry']['viewport']['north']);
                $district->setLngW($district_arr['geometry']['viewport']['west']);
                $district->setLngE($district_arr['geometry']['viewport']['east']);
                
                $district->setRegion($region);

                $em->persist($district);
                $em->flush();
                
                if($place_arr['place_id'] == $district_arr['place_id']){
                    $link = array(
                        'name' => $district->getName(),
                        'href' => $this->generateUrl('location_district_map', array('id' => $district->getId()))
                    );
                    $result = $this->renderView('LocationPlaceBundle:Map:info.html.twig', array('link' => $link));
                }
                
            } elseif($city_arr && $city_arr['geometry']['location']) {
                
                $district = $this->getDoctrine()->getRepository('LocationPlaceBundle:District')->findOneBy(array('google_place_id'=>$city_arr['place_id']));

                if(!$district){
                    $district = new District();
                }

                $district->setName($translater->trans('districts_of_city').' '.$city_arr['address_components'][0]['long_name']);
                $district->setAddress('');
                $district->setGooglePlaceId($city_arr['place_id']);
                
                $city_geometry = $city_arr['geometry'];
                
                $district->setLat(current($city_geometry['location']));
                $district->setLng(end($city_geometry['location']));

                $district->setLatS($city_arr['geometry']['viewport']['south']);
                $district->setLatN($city_arr['geometry']['viewport']['north']);
                $district->setLngW($city_arr['geometry']['viewport']['west']);
                $district->setLngE($city_arr['geometry']['viewport']['east']);
                
                $district->setRegion($region);

                $em->persist($district);
                $em->flush();
            }
            
        }

        
        if($city_arr && isset($district) && $city_arr['geometry']['location']){

            $city = $this->getDoctrine()->getRepository('LocationPlaceBundle:City')->findOneBy(array('google_place_id'=>$city_arr['place_id']));
            
            if(!$city){
                $city = new City();
            }
            
            $city->setName($city_arr['address_components'][0]['long_name']);
            $city->setAddress($city_arr['formatted_address']);
            $city->setGooglePlaceId($city_arr['place_id']);
            $city->setLat(current($city_arr['geometry']['location']));
            $city->setLng(end($city_arr['geometry']['location']));
            
            $city->setLatS($city_arr['geometry']['viewport']['south']);
            $city->setLatN($city_arr['geometry']['viewport']['north']);
            $city->setLngW($city_arr['geometry']['viewport']['west']);
            $city->setLngE($city_arr['geometry']['viewport']['east']);
            
            $city->setDistrict($district);
            
            $em->persist($city);
            $em->flush();
            
            if($place_arr['place_id'] == $city_arr['place_id']){
                $result = $this->renderView('LocationPlaceBundle:Map:info_city.html.twig', array('city' => $city));
            }
            
        }
        
        if(in_array('establishment', $place_arr['types']) && !in_array('continent', $place_arr['types']) && isset($city) && $place_arr['geometry']['location']){
            
            $place = $this->getDoctrine()->getRepository('LocationPlaceBundle:Place')->findOneBy(array('google_place_id'=>$place_arr['place_id']));
            
            if(!$place){
                $place = new Place();
            }
            
            $place->setName($place_arr['name']);
            $place->setAddress($place_arr['formatted_address']);
            $place->setPhone($place_arr['formatted_phone_number']);
            $place->setGooglePlaceId($place_arr['place_id']);
            $place->setGoogleId($place_arr['id']);
            $place->setLat(current($place_arr['geometry']['location']));
            $place->setLng(end($place_arr['geometry']['location']));
            
            $place->setCity($city);

            $em->persist($place);
            $em->flush();
            
            $link = array(
                'name' => $place->getName(),
                'href' => $this->generateUrl('location_place_map', array('id' => $place->getId()))
            );
            $result = $this->renderView('LocationPlaceBundle:Map:info.html.twig', array('link' => $link));
            
        }
        //print_r($location_arr);exit();
//        dump($place_arr);
//        dump($location_arr);exit();
        //return new Response('Find new place');

        return new JsonResponse(array('html' => $result));
        
    }
}
