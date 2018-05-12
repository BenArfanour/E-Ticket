<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/2/18
 * Time: 10:03 PM
 */

namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\categorie;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class CategoriesData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $categorie1 = new Categorie();
        $categorie1->setNom('Sport');
        $categorie1->setImage($this->getReference('media1'));
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setNom('Musique');
        $categorie2->setImage($this->getReference('media7'));
        $manager->persist($categorie2);

        $categorie3 = new Categorie();
        $categorie3->setNom('Les Salles de Theatre');
        $categorie3->setImage($this->getReference('media2'));
        $manager->persist($categorie3);


        $categorie4 = new Categorie();
        $categorie4->setNom('professionnels');
        $categorie4->setImage($this->getReference('media5'));
        $manager->persist($categorie4);
        $manager->flush();

        $categorie5 = new Categorie();
        $categorie5->setNom('World cup 2018');
        $categorie5->setImage($this->getReference('media9'));
        $manager->persist($categorie5);


        $this->setReference('categorie1', $categorie1);
        $this->setReference('categorie2', $categorie2);
        $this->setReference('categorie3', $categorie3);
        $this->setReference('categorie4', $categorie4);
        $this->setReference('categorie5', $categorie5);
    }

    public function getOrder()
    {
        return 2;
    }
}