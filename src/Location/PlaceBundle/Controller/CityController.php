<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\Map;
use Location\PlaceBundle\Entity\City;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function mapAction($id)
    {   
        
        $city = $this->getDoctrine()
            ->getRepository('LocationPlaceBundle:City')
            ->find($id);

        if (!$city) {
            throw $this->createNotFoundException(
                'No city found'
            );
        }
        
        $translater = $this->get('translator');
        
        $places = $city->getPlaces();
        
        $district = $city->getDistrict();
        
        $region = $district->getRegion();
        
        $country = $region->getCountry();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($translater->trans('page_main'), 'location_page_index');
        $breadcrumbs->addRouteItem($country->getName(), 'location_country_map', array('id'=>$country->getId()));
        $breadcrumbs->addRouteItem($region->getName(), 'location_region_map', array('id'=>$region->getId()));
        $breadcrumbs->addRouteItem($district->getName(), 'location_district_map', array('id'=>$district->getId()));
        $breadcrumbs->addRouteItem($city->getName(), 'location_city_map', array('id'=>$city->getId()));
        
        $title = $city->getName().' '.$translater->trans('on_map');
        
        $map = $this->get('ivory_google_map.map');
        
        $map->setAutoZoom(true);
        
        $map->setBound($city->getLatS(), $city->getLngW(), $city->getLatN(), $city->getLngE(), true, true);
        
        return $this->render('LocationPlaceBundle:City:map.html.twig', array('map' => $map, 'title'=>$title, 'city'=>$city, 'places'=>$places));
    }

}
