<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\Map;
use Location\PlaceBundle\Entity\District;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
{
    public function mapAction($id)
    {   
        
        $district = $this->getDoctrine()
            ->getRepository('LocationPlaceBundle:District')
            ->find($id);

        if (!$district) {
            throw $this->createNotFoundException(
                'No district found'
            );
        }
        
        $translater = $this->get('translator');
        
        $cities = $district->getCities();
        
        $region = $district->getRegion();
        
        $country = $region->getCountry();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($region->getName(), 'location_region_map', array('id'=>$region->getId()));
        $breadcrumbs->addRouteItem($district->getName(), 'location_district_map', array('id'=>$district->getId()));
        
        $title = $district->getName().' '.$translater->trans('on_map');
        
        $description = $district->getName().', '.$region->getName().', '.$country->getName();
        
        $map = $this->get('ivory_google_map.map');
        
        $map->setAutoZoom(true);
        
        $map->setBound($district->getLatS(), $district->getLngW(), $district->getLatN(), $district->getLngE(), true, true);
        
        return $this->render('LocationPlaceBundle:District:map.html.twig', array('map' => $map, 'title'=>$title, 'description'=>$description, 'district'=>$district, 'cities'=>$cities));
    }

}
