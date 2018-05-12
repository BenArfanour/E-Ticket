<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/3/18
 * Time: 1:32 PM
 */

namespace AppBundle\Controller;


use Html2Pdf_Html2Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UtilisateurController extends Controller
{

    public function FactureAction() {

        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('AppBundle:Commandes')->byFacture($this->getUser());


        return $this->render('@App/Utilisateurs/facture.html.twig',array('factures'=>$factures));

    }

    public function facturesPDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('AppBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
                                                                                         'valider' => 1,
                                                                                         'id' => $id));

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('factures'));
        }

        $html = $this->renderView('@App/Utilisateurs/facturePDF.html.twig', array('facture' => $facture));

        $html2pdf = new \Html2Pdf_Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
        $html2pdf->pdf->SetAuthor('....');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->Output('facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }

    function activeAction($id) {

        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('AppBundle:user')->find($id);

        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();

        return $this->redirect($this->generateUrl('afficheUsers'));

   }

    function desactiveAction($id) {

        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('AppBundle:user')->find($id);

        $user->setEnabled(false);
        $em->persist($user);
        $em->flush();


        return $this->redirect($this->generateUrl('afficheUsers'));

    }


}