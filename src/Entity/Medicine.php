<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     *
     * @var mixed
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * name
     *
     * @var mixed
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *
     * price
     *
     * @var mixed
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     *
     * weight
     *
     * @var mixed
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     *
     * isRecipeRequired
     *
     * @var mixed
     */
    private $isRecipeRequired;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Substance", inversedBy="medicines")
     *
     * substances
     *
     * @var mixed
     */
    private $substances;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Disease", inversedBy="medicines")
     *
     * diseases
     *
     * @var mixed
     */
    private $diseases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="medicine")
     *
     * opinions
     *
     * @var mixed
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favourites", mappedBy="medicine")
     *
     * favourites
     *
     * @var mixed
     */
    private $favourites;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->substances = new ArrayCollection();
        $this->diseases = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->favourites = new ArrayCollection();
    }
    
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
     * getName
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * setName
     *
     * @param  mixed $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * getPrice
     *
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }
    
    /**
     * setPrice
     *
     * @param  mixed $price
     * @return self
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    /**
     * getWeight
     *
     * @return int
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }
    
    /**
     * setWeight
     *
     * @param  mixed $weight
     * @return self
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    
    /**
     * getIsRecipeRequired
     *
     * @return void
     */
    public function getIsRecipeRequired()
    {
        return $this->isRecipeRequired;
    }
    
    /**
     * setIsRecipeRequired
     *
     * @param  mixed $isRecipeRequired
     * @return void
     */
    public function setIsRecipeRequired($isRecipeRequired): void
    {
        $this->isRecipeRequired = $isRecipeRequired;
    }

    
    /**
     * getSubstances
     *
     * @return Collection
     */
    public function getSubstances(): Collection
    {
        return $this->substances;
    }
    
    /**
     * addSubstance
     *
     * @param  mixed $substance
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
     * removeSubstance
     *
     * @param  mixed $substance
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
     * getDiseases
     *
     * @return Collection
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }
    
    /**
     * addDisease
     *
     * @param  mixed $disease
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
     * removeDisease
     *
     * @param  mixed $disease
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
     * getOpinions
     *
     * @return Collection
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }
    
    /**
     * addOpinion
     *
     * @param  mixed $opinion
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
     * removeOpinion
     *
     * @param  mixed $opinion
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
     * getFavourites
     *
     * @return Collection
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }
    
    /**
     * addFavourite
     *
     * @param  mixed $favourite
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
     * removeFavourite
     *
     * @param  mixed $favourite
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
