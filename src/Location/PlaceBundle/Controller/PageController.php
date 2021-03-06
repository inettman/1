<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {   
        $map = $this->get('ivory_google_map.map');
        return $this->render('LocationPlaceBundle:Page:index.html.twig', ['map' => $map]);
    }
    
    public function sidebarAction()
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy([], ['name'=>'asc']);
        
        return $this->render('LocationPlaceBundle:Page:sidebar.html.twig', ['countries'=>$countries]);
    }
    
    public function menuTopAction()
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy(array('id' => [1, 2, 5]), ['name'=>'asc']);
        
        return $this->render('LocationPlaceBundle:Page:menu_top.html.twig', ['countries'=>$countries]);
    }
    
    public function contentBottomAction($limit = 5)
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy([], ['id'=>'desc'], $limit);
        
        $cities = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:City')
        ->findBy([], ['id'=>'desc'], $limit+5);
        
        $places = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Place')
        ->findBy([], ['id'=>'desc'], $limit);
        
        return $this->render('LocationPlaceBundle:Page:content_bottom.html.twig', ['countries'=>$countries, 'cities'=>$cities, 'places'=>$places]);
    }

}
