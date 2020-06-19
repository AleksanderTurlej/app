<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicineRepository")
 */
class Medicine
{
    public const LIMIT=10;

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
     *
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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Disease", inversedBy="medicines")
     */
    private $diseases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="medicine")
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favourites", mappedBy="medicine")
     */
    private $favourites;

    public function __construct()
    {
        $this->substances = new ArrayCollection();
        $this->diseases = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->favourites = new ArrayCollection();
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

    /**
     * @return Collection|Disease[]
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }

    public function addDisease(Disease $disease): self
    {
        if (!$this->diseases->contains($disease)) {
            $this->diseases[] = $disease;
        }

        return $this;
    }

    public function removeDisease(Disease $disease): self
    {
        if ($this->diseases->contains($disease)) {
            $this->diseases->removeElement($disease);
        }

        return $this;
    }

    /**
     * @return Collection|Opinion[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setMedicine($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->contains($opinion)) {
            $this->opinions->removeElement($opinion);
            // set the owning side to null (unless already changed)
            if ($opinion->getMedicine() === $this) {
                $opinion->setMedicine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favourites[]
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    public function addFavourite(Favourites $favourite): self
    {
        if (!$this->favourites->contains($favourite)) {
            $this->favourites[] = $favourite;
            $favourite->setMedicine($this);
        }

        return $this;
    }

    public function removeFavourite(Favourites $favourite): self
    {
        if ($this->favourites->contains($favourite)) {
            $this->favourites->removeElement($favourite);
            // set the owning side to null (unless already changed)
            if ($favourite->getMedicine() === $this) {
                $favourite->setMedicine(null);
            }
        }

        return $this;
    }
}
