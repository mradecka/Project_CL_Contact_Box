<?php

namespace MR\BoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="MR\BoxBundle\Repository\AddressRepository")
 */
class Address {

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="addresses")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="houseNumber", type="integer")
     */
    private $houseNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="flatNumber", type="integer", nullable=true)
     */
    private $flatNumber;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Set houseNumber
     *
     * @param integer $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return integer 
     */
    public function getHouseNumber() {
        return $this->houseNumber;
    }

    /**
     * Set flatNumber
     *
     * @param integer $flatNumber
     * @return Address
     */
    public function setFlatNumber($flatNumber) {
        $this->flatNumber = $flatNumber;

        return $this;
    }

    /**
     * Get flatNumber
     *
     * @return integer 
     */
    public function getFlatNumber() {
        return $this->flatNumber;
    }


    /**
     * Set user
     *
     * @param \MR\BoxBundle\Entity\User $user
     * @return Address
     */
    public function setUser(\MR\BoxBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MR\BoxBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
