<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
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
     * @var mixed
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * content
     *
     * @var mixed
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     *
     * rating
     *
     * @var mixed
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
     * @var mixed
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     *
     * medicineId
     *
     * @var mixed
     */
    private $medicineId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicine", inversedBy="opinions")
     *
     * medicine
     *
     * @var mixed
     */
    private $medicine;
    
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
     * getContent
     *
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * setContent
     *
     * @param  mixed $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * getRating
     *
     * @return int
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }
    
    /**
     * setRating
     *
     * @param  mixed $rating
     * @return self
     */
    public function setRating(int $rating): self
    {
        $this->rating = $rating;

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
     * getUserId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
    
    /**
     * setUserId
     *
     * @param  mixed $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * getMedicineId
     *
     * @return int
     */
    public function getMedicineId(): int
    {
        return $this->medicineId;
    }
    
    /**
     * setMedicineId
     *
     * @param  mixed $medicineId
     * @return void
     */
    public function setMedicineId(int $medicineId): void
    {
        $this->medicineId = $medicineId;
    }
}
