<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 5/2/18
 * Time: 11:33 AM
 */

namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


use AppBundle\Entity\Media;

class MediaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('http://ichef.bbci.co.uk/news/999/mcs/media/images/80953000/jpg/_80953743_tix2pa.jpg');
        $media1->setAlt('Football');
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setPath('https://media.timeout.com/images/101710063/750/422/image.jpg');
        $media2->setAlt('Theatre');
        $manager->persist($media2);



        $media3 = new Media();
        $media3->setPath('https://www.incimages.com/uploaded_files/image/970x450/getty_499517325_344241.jpg');
        $media3->setAlt('pro');
        $manager->persist($media3);

        $media4 = new Media();
        $media4->setPath('https://www.handballstream.com/wp-content/uploads/2018/03/memorable-handball-match.jpg');
        $media4->setAlt('match hand');
        $manager->persist($media4);

        $media5 = new Media();
        $media5->setPath('https://mahfouzadedimeji.com/wp-content/uploads/2017/07/Conference.jpg');
        $media5->setAlt('conference');
        $manager->persist($media5);

        $media6 = new Media();
        $media6->setPath('https://mahfouzadedimeji.com/wp-content/uploads/2017/07/Conference.jpg');
        $media6->setAlt('test');
        $manager->persist($media6);

        $media7 = new Media();
        $media7->setPath('https://cdn.cnn.com/cnnnext/dam/assets/160923071137-02-marshall-jazz-restricted-super-169.jpg');
        $media7->setAlt('jazz');
        $manager->persist($media7);




        $media9 = new Media();
        $media9->setPath('https://tunigazette.com/wp-content/uploads/2016/06/Tunisia-ftf-world-cup-russia--758x379.png');
        $media9->setAlt('Match foot');
        $manager->persist($media9);

        $manager->flush();

        $this->setReference('media1', $media1);
        $this->setReference('media2', $media2);
        $this->setReference('media3', $media3);
        $this->setReference('media4', $media4);
        $this->setReference('media5', $media5);
        $this->setReference('media6', $media6);
        $this->setReference('media7', $media7);
        $this->setReference('media9', $media9);
    }

    public function getOrder()
    {
        return 1;
    }
}
