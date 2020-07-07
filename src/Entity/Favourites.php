<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavouritesRepository")
 */
class Favourites extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * id
     *
     * @var mixed
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine", inversedBy="favourites")
     *
     * medicine
     *
     * @var mixed
     */
    private $medicine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="favourites")
     *
     * user
     *
     * @var mixed
     */
    private $user;
    
    /**
     * getId
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * getMedicine
     *
     * @return Medicine
     */
    public function getMedicine(): ?Medicine
    {
        return $this->medicine;
    }
    
    /**
     * setMedicine
     *
     * @param  mixed $medicine
     * @return self
     */
    public function setMedicine(?Medicine $medicine): self
    {
        $this->medicine = $medicine;

        return $this;
    }
    
    /**
     * getUser
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    /**
     * setUser
     *
     * @param  mixed $user
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
