<?php

// src/TC/ParkingBundle/Controller/ParkingController.php

namespace TC\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParkingController extends Controller
{
    public function indexAction()
    {
        return $this->render('TCParkingBundle:Parking:index.html.twig');
    }
    public function listingAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
    public function addAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
    public function aboutusAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
    public function contactAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
}
