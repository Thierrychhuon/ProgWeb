<?php

// src/TC/ParkingBundle/Controller/ParkingController.php

namespace TC\ParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TC\PlatformBundle\Entity\Parking;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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

       // On crée le FormBuilder grâce au service form factory
       $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $parking);

       // On ajoute les champs de l'entité que l'on veut à notre formulaire
       $formBuilder
         ->add('adresse',  TextType::class)
         ->add('postcode', 'integer', array('max_length'=>5))
         ->add('phone', 'integer', array('max_length'=>10))
         ->add('description',   TextareaType::class)
         ->add('save',      SubmitType::class)
       ;
       // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

       // À partir du formBuilder, on génère le formulaire
       $form = $formBuilder->getForm();

       // On passe la méthode createView() du formulaire à la vue
       // afin qu'elle puisse afficher le formulaire toute seule
       return $this->render('TCPlatformBundle:Advert:add.html.twig', array(
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
}
