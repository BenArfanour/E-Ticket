<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/3/18
 * Time: 4:12 AM
 */

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class getReference
{

    public function __construct(securityContext $sec ,EntityManager $em)
    {
        $this->sec = $sec;
        $this->em = $em;
    }

    public function reference()
    {

        $reference = $this->em->getRepository('AppBundle:Commandes')->findOneBy(array('valider' => 1), array('id' => 'DESC'));

        if (!$reference)
            return 1;
        else
            return $reference->getReference() +1;
    }

}
