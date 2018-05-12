<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/27/18
 * Time: 4:15 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorieController extends Controller
{

    public function MenuAction() {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:categorie')->findAll();

        return $this->render('AppBundle:Categorie/ModuleUsed:menu.html.twig',array('categories'=>$categories));


    }
}