<?php

namespace PagesBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/17/18
 * Time: 6:45 PM
 */

class Pages1Controller extends Controller
{
    public function MenuAction() {

        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PagesBundle:Pages')->findAll();


        return $this->render('PagesBundle:Pages/ModulesUser:menu.html.twig',array('pages'=>$pages));


    }

    public function  pagesAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesBundle:Pages')->find($id);

        if (!$page) throw $this->createNotFoundException('La page n\'existe pas.');

        return $this->render('@Pages/Pages/Layout/Page.html.twig', array('page' => $page));
    }
}