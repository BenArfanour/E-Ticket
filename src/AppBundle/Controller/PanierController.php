<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/17/18
 * Time: 4:52 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\UtilisateursAdresse;
use AppBundle\Form\UtilisateursAdresseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanierController extends Controller
{

    public function MenuAction() {
        $session = $this->getRequest()->getSession();
        if (!$session->has('panier'))
            $billet = 0 ;
        else
            $billet = count($session->get('panier')) ;

        return $this->render('@App/Panier/modulesuser/panier.html.twig',array('billet'=>$billet ));


    }
    public function ajouterAction($id) {

            $session = $this->getRequest()->getSession();

            if (!$session->has('panier')) $session->set('panier',array());
            $panier = $session->get('panier');

            if (array_key_exists($id, $panier)) {
                if ($this->getRequest()->query->get('qte') != null) $panier[$id] = $this->getRequest()->query->get('qte');
                $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
            } else {
                if ($this->getRequest()->query->get('qte') != null)
                    $panier[$id] = $this->getRequest()->query->get('qte');
                else
                    $panier[$id] = 1;

                $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
            }

            $session->set('panier',$panier);


            return $this->redirect($this->generateUrl('panier'));
    }

    public function supprimerAction($id) {



        $session = $this->getRequest()->getSession();
        $panier = $session->get('panier') ;

        if (array_key_exists($id,$panier)) {
            unset($panier[$id]) ;
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','billet supprimer avec succes');

        }

        return $this->redirect($this->generateUrl('panier')) ;

    }
    /**
     * @Route("/panier", name="panier")
     */
    public function PanierAction() {

        $session = $this->getRequest()->getSession();
        if (!$session->has('panier'))
            $session->set('panier',array());

        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Produit')->findArray(array_keys($session->get('panier')));

        return $this->render('@App/Panier/layout/panier.html.twig',array('produits'=>$produits ,
                                                                                'panier'=>$session->get('panier')));
    }

    /**
     * @Route("/panier/livraison", name="livraison")
     */
    public function LivraisonAction() {

        $user= $this->container->get('security.context')->getToken()->getUser();
        $entity = new UtilisateursAdresse();
        $form = $this->createForm(new UtilisateursAdresseType(), $entity);

        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($user);
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('livraison'));
            }
        }


        return $this->render('@App/Panier/layout/livraison.html.twig',array('user'=>$user,
                                                                          'form'=>$form->createView()));
    }




    public function setLivraisonOnSession()
    {
        $session = $this->getRequest()->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        if ($this->getRequest()->request->get('livraison') != null && $this->getRequest()->request->get('facturation') != null)
        {
            $adresse['livraison'] = $this->getRequest()->request->get('livraison');
            $adresse['facturation'] = $this->getRequest()->request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }

         $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }



    /**
     * @Route("SuppresionAdresse/{id}",name="livraisonAdresseSuppression")
     */
    public function suppressionAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:UtilisateursAdresse')->find($id);

        if ($this->container->get('security.context')->getToken()->getUser() != $entity->getUtilisateur() || !$entity)
            return $this->redirect ($this->generateUrl ('livraison'));

        $em->remove($entity);
        $em->flush();

        return $this->redirect ($this->generateUrl ('livraison'));
    }

    /**
     * @Route("/panier/validation", name="validation")
     */

    public function validationAction()
    {

        if ($this->get('request')->getMethod() == 'POST')
            $this->setLivraisonOnSession();

        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('AppBundle:Commandes:prepareCommande');
        $commande = $em->getRepository('AppBundle:Commandes')->find($prepareCommande->getContent());


        return $this->render('@App/Panier/layout/validation.html.twig', array('commande' => $commande));
    }

}