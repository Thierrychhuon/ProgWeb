<?php

// src/TC/ParkingBundle/Controller/ParkingController.php

namespace TC\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TC\ParkingBundle\Entity\Parking;
use TC\ParkingBundle\Form\ParkingEditType;
use TC\ParkingBundle\Form\ParkingType;

class ParkingController extends Controller
{
    public function indexAction()
    {
        return $this->render('TCParkingBundle:Parking:index.html.twig');
    }

    public function listingAction()
    {
      $listParkings = $this->getDoctrine()
      ->getManager()
      ->getRepository('TCParkingBundle:Parking')
      ->findAll()
    ;

    // L'appel de la vue ne change pas
    return $this->render('TCParkingBundle:Parking:listing.html.twig', array(
      'listParkings' => $listParkings,
    ));
    }

    public function addAction(Request $request)
    {
      $parking = new Parking();
      $form = $this->get('form.factory')->create(ParkingType::class, $parking);
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
      $em = $this->getDoctrine()->getManager();
      $em->persist($parking);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Parking bien enregistré.');
      return $this->redirectToRoute('tc_parking_view', array('id' => $parking->getId()));
      }
      return $this->render('TCParkingBundle:Parking:add.html.twig', array(
        'form' => $form->createView(),
      ));
     }

    public function aboutusAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
    public function contactAction()
    {
        return $this->render('::layoutparking.html.twig');
    }
    public function testAction()
    {
        return $this->render('::layoutparking2.html.twig');
    }
    public function viewAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $parking = $em->getRepository('TCParkingBundle:Parking')->find($id);
      if (null === $parking) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }
      return $this->render('TCParkingBundle:Parking:view.html.twig', array(
        'parking'           => $parking,
      ));
    }

    public function deleteAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $parking = $em->getRepository('TCParkingBundle:Parking')->find($id);
      if (null === $parking) {
        throw new NotFoundHttpException("Le parking d'id ".$id." n'existe pas.");
      }
      // On crée un formulaire vide, qui ne contiendra que le champ CSRF
      // Cela permet de protéger la suppression d'annonce contre cette faille
      $form = $this->get('form.factory')->create();
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->remove($parking);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Le parking a bien été supprimé.");
        return $this->redirectToRoute('tc_parking_home');
      }
        return $this->render('TCParkingBundle:Parking:delete.html.twig', array(
         'parking' => $parking,
         'form'   => $form->createView(),
       ));
     }

    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $parking = $em->getRepository('TCParkingBundle:Parking')->find($id);
      if (null === $parking) {
        throw new NotFoundHttpException("Le parking d'id ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(ParkingEditType::class, $parking);
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        // Inutile de persister ici, Doctrine connait déjà notre annonce
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', 'Parking bien modifié.');
        return $this->redirectToRoute('tc_parking_view', array('id' => $parking->getId()));
      }
      return $this->render('TCParkingBundle:Parking:edit.html.twig', array(
        'parking' => $parking,
        'form'   => $form->createView(),
      ));
    }
}
