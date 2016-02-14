<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Location\PlaceBundle\Entity\Country;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    public function mapAction($id)
    {   
        $country = $this->getDoctrine()
            ->getRepository('LocationPlaceBundle:Country')
            ->find($id);

        if (!$country) {
            throw $this->createNotFoundException(
                'No country found'
            );
        }
        
        $translater = $this->get('translator');
        
        $regions = $country->getRegions();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($translater->trans('page_main'), 'location_page_index');
        $breadcrumbs->addRouteItem($country->getName(), 'location_country_map', array('id'=>$country->getId()));
        
        $title = $country->getName().' '.$translater->trans('on_map').' ('.$country->getAddress().')';
        
        $description = $title;
        
        $map = $this->get('ivory_google_map.map');
        
        $map->setAutoZoom(true);
        
        $map->setBound($country->getLatS(), $country->getLngW(), $country->getLatN(), $country->getLngE(), true, true);
        
        return $this->render('LocationPlaceBundle:Country:map.html.twig', array('map' => $map, 'title'=>$title, 'description'=>$description, 'country'=>$country, 'regions'=>$regions));
    }

}
