<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/29/18
 * Time: 2:49 AM
 */

namespace AppBundle\Twig\Extension;


class montantTvaExtension extends \Twig_Extension
{

    public function getFilters() {

        return array(new \Twig_SimpleFilter('tva',array($this,'montantTva')));
    }

    public function montantTva($prixHT,$tva) {

        return round((($prixHT / $tva ) - $prixHT),2);

    }

    public function getName() {

        return 'montantTva_extension';
    }

}

