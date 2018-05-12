<?php

namespace AppBundle\Controller;

use AppBundle\Entity\categorie;
use AppBundle\Form\RechercheType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class Produit1Controller extends Controller
{
    /**
     * @Route("", name="homepage")
     */
    public function indexAction(categorie $categorie = null)
    {
        //var_dump($categorie);
        //die();
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        if ($categorie != null )
            $produits = $em->getRepository('AppBundle:Produit')->byCategorie($categorie);
        else
            $produits = $em->getRepository('AppBundle:Produit')->findBy(array('disponible'=> 1));

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false ;

            return $this->render('@App/produit/layout/produit.html.twig',array('produits'=>$produits,
                                                                                     'panier'=>$panier   ));
    }


 public function categorieAction($categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Produit')->byCategorie($categorie);
        $cat = $em->getRepository('AppBundle:categorie')->find($categorie);

        //test sur la categorie
         if (!$cat) {
             throw $this->createNotFoundException('la page n\'existe pas ');
         }


        return $this->render('@App/produit/layout/produit.html.twig',array('produits'=>$produits));
    }



    /**
     * @Route("/produit/{id}", name="produits")
     */
    public function presentationAction($id)
    {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('AppBundle:Produit')->find($id);

        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false ;


         if (!$produit) {
             throw $this->createNotFoundException('la page n\'existe pas ');
         }
        return $this->render('@App/produit/layout/presentation.html.twig',array('produit'=>$produit,'panier'=>$panier));
    }

    public function rechercheAction() {

        $form = $this->createForm( new RechercheType());
        return $this->render('@App/Recherche/ModuleUsed/recherche.html.twig',array('form'=>$form->createView()));

    }

    /**
     * @Route("/rechercheProduit",name="recherchePro")
     */
    public function  recherchetraitementAction() {


        $form = $this->createForm( new RechercheType());
        if ($this->get('request')->getMethod()== 'POST') {

            $form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('AppBundle:Produit')->recherche($form['recherche']->getData());

        }
        else {
            throw $this->createNotFoundException('Ticket invalide !');
         }
        return $this->render('@App/produit/layout/produit.html.twig',array('produits'=>$produits));
    }
}
