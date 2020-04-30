<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicineRepository")
 */
class Medicine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRecipeRequired;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Substance", inversedBy="medicines")
     */
    private $substances;

    public function __construct()
    {
        $this->substances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsRecipeRequired()
    {
        return $this->isRecipeRequired;
    }

    /**
     * @param mixed $isRecipeRequired
     */
    public function setIsRecipeRequired($isRecipeRequired): void
    {
        $this->isRecipeRequired = $isRecipeRequired;
    }

    /**
     * @return Collection|Substance[]
     */
    public function getSubstances(): Collection
    {
        return $this->substances;
    }

    public function addSubstance(Substance $substance): self
    {
        if (!$this->substances->contains($substance)) {
            $this->substances[] = $substance;
        }

        return $this;
    }

    public function removeSubstance(Substance $substance): self
    {
        if ($this->substances->contains($substance)) {
            $this->substances->removeElement($substance);
        }

        return $this;
    }
}
