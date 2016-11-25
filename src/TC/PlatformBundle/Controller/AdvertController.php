<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace TC\PlatformBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
  public function indexAction($page)
 {
   if ($page < 1) {
     throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
   }
   // Notre liste d'annonce en dur
   $listAdverts = array(
     array(
       'title'   => 'Recherche développpeur Symfony',
       'id'      => 1,
       'author'  => 'Alexandre',
       'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
       'date'    => new \Datetime()),
     array(
       'title'   => 'Mission de webmaster',
       'id'      => 2,
       'author'  => 'Hugo',
       'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
       'date'    => new \Datetime()),
     array(
       'title'   => 'Offre de stage webdesigner',
       'id'      => 3,
       'author'  => 'Mathieu',
       'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
       'date'    => new \Datetime())
   );
   return $this->render('TCPlatformBundle:Advert:index.html.twig', array(
     'listAdverts' => $listAdverts,
   ));
 }

 public function index2Action(){
   return $this->render('TCPlatformBundle:Advert:test.html.twig');
 }
 
 public function viewAction($id)
 {
   $advert = array(
     'title'   => 'Recherche développpeur Symfony',
     'id'      => $id,
     'author'  => 'Alexandre',
     'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
     'date'    => new \Datetime()
   );
   return $this->render('TCPlatformBundle:Advert:view.html.twig', array(
     'advert' => $advert
   ));
 }

  // On récupère tous les paramètres en arguments de la méthode
  public function viewSlugAction($slug, $year, $_format)
  {
      return new Response(
          "On pourrait afficher l'annonce correspondant au
          slug '".$slug."', créée en ".$year." et au format ".$_format."."
      );
  }

  public function addAction(Request $request)
  {
    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('tc_platform_view', array('id' => 5));
    }
    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('TCPlatformBundle:Advert:add.html.twig');
  }

  public function editAction($id, Request $request)
  {
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
      return $this->redirectToRoute('tc_platform_view', array('id' => 5));
    }
    $advert = array(
      'title'   => 'Recherche développpeur Symfony',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    );
    return $this->render('TCPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    // Ici, on récupérera l'annonce correspondant à $id
    // Ici, on gérera la suppression de l'annonce en question
    return $this->render('TCPlatformBundle:Advert:delete.html.twig');
  }

  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );
    return $this->render('TCPlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
}
