<?php

namespace Location\PlaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {   
        return $this->render('LocationPlaceBundle:Page:index.html.twig');
    }
    
    public function sidebarAction()
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy(array(), array('name'=>'asc'));
        
        return $this->render('LocationPlaceBundle:Page:sidebar.html.twig', array('countries'=>$countries));
    }
    
    public function menuTopAction()
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy(array('id' => array(1, 2, 5)), array('name'=>'asc'));
        
        return $this->render('LocationPlaceBundle:Page:menu_top.html.twig', array('countries'=>$countries));
    }
    
    public function contentBottomAction($limit = 5)
    {   
        $countries = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Country')
        ->findBy(array(), array('id'=>'desc'), $limit);
        
        $cities = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:City')
        ->findBy(array(), array('id'=>'desc'), $limit+5);
        
        $places = $this->getDoctrine()
        ->getRepository('LocationPlaceBundle:Place')
        ->findBy(array(), array('id'=>'desc'), $limit);
        
        return $this->render('LocationPlaceBundle:Page:content_bottom.html.twig', array('countries'=>$countries, 'cities'=>$cities, 'places'=>$places));
    }

}
