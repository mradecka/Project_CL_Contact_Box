<?php

namespace MR\BoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MR\BoxBundle\Repository\UserRepository")
 */
class User {

    public function __construct() {
        $this->addresses = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="user")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="user")
     */
    private $emails;

    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="user")
     */
    private $phones;

    /**
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param \MR\BoxBundle\Entity\Address $address
     * @return User
     */
    public function setAddress(\MR\BoxBundle\Entity\Address $address = null) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \MR\BoxBundle\Entity\Address 
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Add addresses
     *
     * @param \MR\BoxBundle\Entity\Address $addresses
     * @return User
     */
    public function addAddress(\MR\BoxBundle\Entity\Address $addresses) {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \MR\BoxBundle\Entity\Address $addresses
     */
    public function removeAddress(\MR\BoxBundle\Entity\Address $addresses) {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses() {
        return $this->addresses;
    }

    /**
     * Add phones
     *
     * @param \MR\BoxBundle\Entity\Phone $phones
     * @return User
     */
    public function addPhone(\MR\BoxBundle\Entity\Phone $phones) {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \MR\BoxBundle\Entity\Phone $phones
     */
    public function removePhone(\MR\BoxBundle\Entity\Phone $phones) {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones() {
        return $this->phones;
    }


    /**
     * Add emails
     *
     * @param \MR\BoxBundle\Entity\Email $emails
     * @return User
     */
    public function addEmail(\MR\BoxBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \MR\BoxBundle\Entity\Email $emails
     */
    public function removeEmail(\MR\BoxBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
