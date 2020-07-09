<?php
/**
 * Opinion entity.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Opinion.
 *
 * @ORM\Entity(repositoryClass="App\Repository\OpinionRepository")
 */
class Opinion extends AbstractEntity
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
     * @ORM\Column(type="string", length=255)
     *
     * content
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(min="20",max="255")
     *
     * @var string
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     *
     * rating
     *
     * @Assert\Type(type="int")
     * @Assert\NotBlank
     *
     * @var int
     */
    private $rating;

    /**
     * @ORM\Column(type="integer")
     *
     * userId
     *
     * @var int
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="opinions")
     *
     * user
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     *
     * medicineId
     */
    private $medicineId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine", inversedBy="opinions")
     *
     * medicine
     *
     * @var Medicine
     */
    private $medicine;

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
     * getContent.
     *
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * setContent.
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * getRating.
     *
     * @return int
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * setRating.
     */
    public function setRating(int $rating): self
    {
        $this->rating = $rating;

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
     * @param User $user
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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
     */
    public function setMedicine(?Medicine $medicine): self
    {
        $this->medicine = $medicine;

        return $this;
    }

    /**
     * getUserId.
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * setUserId.
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * getMedicineId.
     */
    public function getMedicineId(): int
    {
        return $this->medicineId;
    }

    /**
     * setMedicineId.
     */
    public function setMedicineId(int $medicineId): void
    {
        $this->medicineId = $medicineId;
    }
}
