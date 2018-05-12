<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/2/18
 * Time: 10:08 PM
 */

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Entity\tva;

class TvaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tva1 = new tva();
        $tva1->setMultiplicate('0.982');
        $tva1->setNom('TVA 1.75%');
        $tva1->setValeur('1.75');
        $manager->persist($tva1);

        $tva2 = new Tva();
        $tva2->setMultiplicate('0.833');
        $tva2->setNom('TVA 20%');
        $tva2->setValeur('20');
        $manager->persist($tva2);

        $manager->flush();

        $this->setReference('tva1', $tva1);
        $this->setReference('tva2', $tva2);

    }

    public function getOrder()
    {
        return 3;
    }

}