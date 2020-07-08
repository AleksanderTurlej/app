<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var int
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
     * getId.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getMedicine.
     *
     * @return Medicine
     */
    public function getMedicine(): ?Medicine
    {
        return $this->medicine;
    }

    /**
     * setMedicine.
     *
     * @param Medicine $medicine
     *
     * @return self
     */
    public function setMedicine(?Medicine $medicine): self
    {
        $this->medicine = $medicine;

        return $this;
    }

    /**
     * getUser.
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * setUser.
     *
     * @param mixed $user
     *
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
