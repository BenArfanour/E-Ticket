<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/3/18
 * Time: 8:23 PM
 */

namespace AppBundle\Controller;




use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/admin/users",name="afficheUsers")
     */

    public function AfficheUser() {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:user')->findAll();

        return $this->render('user.html.twig',array('users'=>$users));
    }

}