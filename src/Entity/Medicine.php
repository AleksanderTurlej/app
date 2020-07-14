<?php
/**
 * Medicine entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Medicine.
 *
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
     * @ORM\Column(type="string", length=255)
     *
     * description
     *
     * @Assert\Type(type="string")
     *
     * @var string
     */
    private $description;

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
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getDescription.
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * setDescription.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     */
    public function getSubstances(): Collection
    {
        return $this->substances;
    }

    /**
     * addSubstance.
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
     */
    public function getDiseases(): Collection
    {
        return $this->diseases;
    }

    /**
     * addDisease.
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
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    /**
     * addOpinion.
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
     */
    public function getFavourites(): Collection
    {
        return $this->favourites;
    }

    /**
     * addFavourite.
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
