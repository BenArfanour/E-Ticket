<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 3/29/18
 * Time: 2:22 AM
 */

namespace AppBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\userRepository")
 */
class user extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->commandes= new \Doctrine\Common\Collections\ArrayCollection() ;
        $this->adresses= new \Doctrine\Common\Collections\ArrayCollection() ;
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commandes",mappedBy="utilisateur",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */

    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UtilisateursAdresse",mappedBy="utilisateur",cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */

    private $adresses;

    /**
     * Add commandes
     *
     * @param \AppBundle\Entity\Commandes $commandes
     * @return user
     */
    public function addCommande(\AppBundle\Entity\Commandes $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \AppBundle\Entity\Commandes $commandes
     */
    public function removeCommande(\AppBundle\Entity\Commandes $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adresses
     *
     * @param \AppBundle\Entity\UtilisateursAdresse $adresses
     * @return user
     */
    public function addAdress(\AppBundle\Entity\UtilisateursAdresse $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \AppBundle\Entity\UtilisateursAdresse $adresses
     */
    public function removeAdress(\AppBundle\Entity\UtilisateursAdresse $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
