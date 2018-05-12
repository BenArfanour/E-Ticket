<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/2/18
 * Time: 10:05 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Produit;

class ProduitsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produit();
        $produit1->setCategorie($this->getReference('categorie1'));
        $produit1->setDescription("sport");
        $produit1->setDisponible('1');
        $produit1->setImage($this->getReference('media1'));
        $produit1->setNom('Tunisa Vs Russia');
        $produit1->setPrix('20');
        $produit1->setTva($this->getReference('tva2'));
        $manager->persist($produit1);


        $produit2 = new Produit();
        $produit2->setCategorie($this->getReference('categorie1'));
        $produit2->setDescription("RUSSIA 2018");
        $produit2->setDisponible('1');
        $produit2->setImage($this->getReference('media9'));
        $produit2->setNom('World CUP 2018');
        $produit2->setPrix('35');
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);


        $produit3 = new Produit();
        $produit3->setCategorie($this->getReference('categorie1'));
        $produit3->setDescription("match hand");
        $produit3->setDisponible('1');
        $produit3->setImage($this->getReference('media4'));
        $produit3->setNom('HandBall');
        $produit3->setPrix('23');
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);

        $produit4 = new Produit();
        $produit4->setCategorie($this->getReference('categorie3'));
        $produit4->setDescription("Opera");
        $produit4->setDisponible('1');
        $produit4->setImage($this->getReference('media2'));
        $produit4->setNom('Opera');
        $produit4->setPrix('555');
        $produit4->setTva($this->getReference('tva2'));
        $manager->persist($produit4);

        $produit5 = new Produit();
        $produit5->setCategorie($this->getReference('categorie2'));
        $produit5->setDescription("jazz");
        $produit5->setDisponible('1');
        $produit5->setImage($this->getReference('media7'));
        $produit5->setNom('Jazz');
        $produit5->setPrix('70');
        $produit5->setTva($this->getReference('tva2'));
        $manager->persist($produit5);

        $produit6 = new Produit();
        $produit6->setCategorie($this->getReference('categorie4'));
        $produit6->setDescription("Conference");
        $produit6->setDisponible('1');
        $produit6->setImage($this->getReference('media5'));
        $produit6->setNom('Conference');
        $produit6->setPrix('10');
        $produit6->setTva($this->getReference('tva2'));
        $manager->persist($produit6);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}