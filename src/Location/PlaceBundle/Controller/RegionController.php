<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMapBundle\Model\Map;
use Location\PlaceBundle\Entity\Region;
use Symfony\Component\HttpFoundation\Response;

class RegionController extends Controller
{
    public function mapAction($id)
    {   
        
        $region = $this->getDoctrine()
            ->getRepository('LocationPlaceBundle:Region')
            ->find($id);

        if (!$region) {
            throw $this->createNotFoundException(
                'No region found'
            );
        }
        
        $translater = $this->get('translator');
        
        $districts = $region->getDistricts();
        
        $country = $region->getCountry();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($translater->trans('page_main'), 'location_page_index');
        $breadcrumbs->addRouteItem($country->getName(), 'location_country_map', array('id'=>$country->getId()));
        $breadcrumbs->addRouteItem($region->getName(), 'location_region_map', array('id'=>$region->getId()));
        
        $title = $region->getName().' '.$translater->trans('on_map');
        
        $description = $region->getName().', '.$country->getName();
        
        $map = $this->get('ivory_google_map.map');
        
        $map->setAutoZoom(true);
        
        $map->setBound($region->getLatS(), $region->getLngW(), $region->getLatN(), $region->getLngE(), true, true);
        
        return $this->render('LocationPlaceBundle:Region:map.html.twig', array('map' => $map, 'title'=>$title, 'description'=>$description, 'region'=>$region, 'districts'=>$districts));
    }

}
