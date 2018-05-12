<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/28/18
 * Time: 5:40 PM
 */

namespace AppBundle\Twig\Extension;


class TvaExtension extends \Twig_Extension
{

    public function getFilters() {

        return array(new \Twig_SimpleFilter('tva',array($this,'calculTva')));
    }

     public function calculTva($prixHT,$tva) {

        return round($prixHT / $tva,2);
     }

     public function getName() {

        return 'tva_extension';
     }

}
