<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicineRepository")
 */
class Medicine extends AbstractEntity
{
    public const LIMIT = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     *
     * id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * name
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(min="3",max="45")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * price
     *
     * @Assert\Type(type="int")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     *
     * weight
     *
     * @Assert\Type(type="int")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     *
     * isRecipeRequired
     *
     * @Assert\Type(type="bool")
     * @Assert\NotBlank
     *
     * @var bool
     */
    private $isRecipeRequired;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Substance", inversedBy="medicines", fetch="EXTRA_LAZY")
     *
     * substances
     *
     * @var ArrayCollection
     */
    private $substances;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Disease", inversedBy="medicines", fetch="EXTRA_LAZY")
     *
     * diseases
     *
     * @var ArrayCollection
     */
    private $diseases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="medicine", fetch="EXTRA_LAZY")
     *
     * opinions
     *
     * @var ArrayCollection
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favourites", mappedBy="medicine", fetch="EXTRA_LAZY")
     *
     * favourites
     *
     * @var ArrayCollection
     */
    private $favourites;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->substances = new ArrayCollection();
        $this->diseases = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->favourites = new ArrayCollection();
    }

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
     * getName.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * setName.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getPrice.
     *
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * setPrice.
     *
     * @param int $price
     *
     * @return self
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * getWeight.
     *
     * @return int
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * setWeight.
     *
     * @param int $weight
     *
     * @return self
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * getIsRecipeRequired.
     */
    public function getIsRecipeRequired()
    {
        return $this->isRecipeRequired;
    }

    /**
     * setIsRecipeRequired.
     *
     * @param void $isRecipeRequired
     */
    public function setIsRecipeRequired($isRecipeRequired): void
    {
        $this->isRecipeRequired = $isRecipeRequired;
    }

    /**
     * getSubstances.
     *
     * @return Collection
     */
    public function getSubstances(): Collection
    {
        return $this->substances;
    }

    /**
     * addSubstance.
     *
     * @param Substance $substance
     *
     * @return self
     */
    public function addSubstance(Substance $substance): self
    {
        if (!$this->substances->contains($substance)) {
            $this->substances[] = $substance;
        }

        return $this;
    }

    /**
     * removeSubstance.
     *
     * @param Substance $substance
     *
     * @return self
     */
    public function removeSubstance(Substance $substance): self
    {
        if ($this->substances->contains($substance)) {
            $this->substances->removeElement($substance);
        }

        return $this;
    }

    /**
     * getDiseases.
     *
     * @return Collection
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }

    /**
     * addDisease.
     *
     * @param Disease $disease
     *
     * @return self
     */
    public function addDisease(Disease $disease): self
    {
        if (!$this->diseases->contains($disease)) {
            $this->diseases[] = $disease;
        }

        return $this;
    }

    /**
     * removeDisease.
     *
     * @param Disease $disease
     *
     * @return self
     */
    public function removeDisease(Disease $disease): self
    {
        if ($this->diseases->contains($disease)) {
            $this->diseases->removeElement($disease);
        }

        return $this;
    }

    /**
     * getOpinions.
     *
     * @return Collection
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    /**
     * addOpinion.
     *
     * @param Opinion $opinion
     *
     * @return self
     */
    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setMedicine($this);
        }

        return $this;
    }

    /**
     * removeOpinion.
     *
     * @param Opinion $opinion
     *
     * @return self
     */
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
     * getFavourites.
     *
     * @return Collection
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    /**
     * addFavourite.
     *
     * @param Favourites $favourite
     *
     * @return self
     */
    public function addFavourite(Favourites $favourite): self
    {
        if (!$this->favourites->contains($favourite)) {
            $this->favourites[] = $favourite;
            $favourite->setMedicine($this);
        }

        return $this;
    }

    /**
     * removeFavourite.
     *
     * @param Favourites $favourite
     *
     * @return self
     */
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
