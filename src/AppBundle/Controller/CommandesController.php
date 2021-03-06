<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/1/18
 * Time: 12:28 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Commandes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class CommandesController extends Controller
{

    public function facture()
    {
        $em = $this->getDoctrine()->getManager();
        $generator = $this->container->get('security.secure_random');
        $session = $this->getRequest()->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;
        $totalTTC = 0;

        $facturation = $em->getRepository('AppBundle:UtilisateursAdresse')->find($adresse['facturation']);
        $livraison = $em->getRepository('AppBundle:UtilisateursAdresse')->find($adresse['livraison']);
        $produits = $em->getRepository('AppBundle:Produit')->findArray(array_keys($session->get('panier')));

        foreach ($produits as $produit) {

            $prixHT = ($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC = ($produit->getPrix() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicate());
            $totalHT += $prixHT;
            $totalTTC += $prixTTC;

            if (!isset($commande['tva']['%' . $produit->getTva()->getValeur()]))
                $commande['tva']['%' . $produit->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
            else
                $commande['tva']['%' . $produit->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);

            $commande['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
                'quantite' => $panier[$produit->getId()],
                'prixHT' => round($produit->getPrix(), 2),
                'prixTTC' => round($produit->getPrix() / $produit->getTva()->getMultiplicate(), 2));
        }

                    $commande['livraison'] = array('prenom' => $livraison->getPrenom(),
                        'nom' => $livraison->getNom(),
                        'telephone' => $livraison->getTelephone(),
                        'adresse' => $livraison->getAdresse(),
                        'cp' => $livraison->getCp(),
                        'ville' => $livraison->getVille(),
                        'pays' => $livraison->getPays(),
                        'complement' => $livraison->getComplement());
                    $commande['facturation'] = array('prenom' => $facturation->getPrenom(),
                        'nom' => $facturation->getNom(),
                        'telephone' => $facturation->getTelephone(),
                        'adresse' => $facturation->getAdresse(),
                        'cp' => $facturation->getCp(),
                        'ville' => $facturation->getVille(),
                        'pays' => $facturation->getPays(),
                        'complement' => $facturation->getComplement());
                    $commande['prixHT'] = round($totalHT, 2);
                    $commande['prixTTC'] = round($totalTTC, 2);
                    $commande['token'] = bin2hex($generator->nextBytes(20));
                    return $commande;
    }

    public function prepareCommandeAction()
            {
                $session = $this->getRequest()->getSession();
                $em = $this->getDoctrine()->getManager();

                if (!$session->has('commande'))
                    $commande = new Commandes();
                else
                    $commande = $em->getRepository('AppBundle:Commandes')->find($session->get('commande'));

                $commande->setDate(new \DateTime());
                $commande->setUtilisateur($this->container->get('security.context')->getToken()->getUser());
                $commande->setValider(0);
                $commande->setReference(0);
                $commande->setCommande($this->facture());

                if (!$session->has('commande')) {
                    $em->persist($commande);
                    $session->set('commande', $commande);
                }

                $em->flush();

                return new Response($commande->getId());
             }

    /**
     * @Route("/api/banque/{id}",name="ValidationCommandes")
     */
    public function validationCommandeAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $commande = $em->getRepository('AppBundle:Commandes')->find($id);

            if (!$commande || $commande->getValider() == 1)
                throw $this->createNotFoundException('La commande n\'existe pas');

            $commande->setValider(1);
            $commande->setReference($this->container->get('SetNewReference')->reference()); //Service
            $em->flush();


            $session = $this->getRequest()->getSession();
            $session->remove('adresse');
            $session->remove('panier');
            $session->remove('commande');

            $this->get('session')->getFlashBag()->add('success', 'Votre commande est validé avec succès');
            return $this->redirect($this->generateUrl('factures'));
    }


    public function afficheAction() {

        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('AppBundle:Commandes')->findAll();

        return $this->render('@App/cammandes.html.twig',array('commandes'=>$commandes)) ;

    }

    public function annulerAction($id)  {


        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:Commandes')->find($id);

        $em->remove($commande);
        $em->flush();


        return $this->redirect($this->generateUrl('commandesAffiche'));


    }
}