<?php

// src/TC/ParkingBundle/Controller/ParkingController.php

namespace TC\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TC\ParkingBundle\Entity\Parking;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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

    public function addAction(Request $request)
    {

      // On crée un objet Advert
      $parking = new Parking();

      // J'ai raccourci cette partie, car c'est plus rapide à écrire !
      $form = $this->get('form.factory')->createBuilder(FormType::class, $parking)
        ->add('adresse',     TextType::class)
        ->add('postcode',    NumberType::class)
        ->add('telephone', NumberType::class)
        ->add('description',   TextareaType::class)
        ->add('save',      SubmitType::class)
        ->getForm()
      ;
        // Si la requête est en POST
      if ($request->isMethod('POST')) {
        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
          // On enregistre notre objet $advert dans la base de données, par exemple
          $em = $this->getDoctrine()->getManager();
          $em->persist($parking);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirectToRoute('tc_parking_home', array('id' => $parking->getId()));
        }
      }
      // À ce stade, le formulaire n'est pas valide car :
      // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
      // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
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
    // Pour récupérer une seule annonce, on utilise la méthode find($id)
    $parking = $em->getRepository('TCParkingBundle:Parking')->find($id);
    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id n'existe pas, d'où ce if :
    if (null === $parking) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    // Récupération de la liste des candidatures de l'annonce
    //$listApplications = $em
    //  ->getRepository('OCPlatformBundle:Application')
    //  ->findBy(array('advert' => $advert))
    //;

    return $this->render('TCParkingBundle:Parking:view.html.twig', array(
      'parking'           => $parking,
    ));
  }

}
