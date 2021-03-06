<?php
/**
 * User entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="email_idx",
 *              columns={"email"},
 *          )
 *     }
 * )
 *
 * @UniqueEntity(fields={"email"})
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * Role user.
     *
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';

    /**
     * Role admin.
     *
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     */
    private $id;

    /**
     * Nick.
     *
     * @var string|null
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="50",
     * )
     *
     * @ORM\Column(
     *     type="string",
     *     nullable=false,
     *     )
     */
    private $nick;

    /**
     * E-mail.
     *
     * @var string
     *
     * @Assert\Email()
     * @Assert\Length(
     *     min="3",
     *     max="50",
     * )
     * @ORM\Column(
     *     type="string",
     *     length=180,
     *     unique=true,
     * )
     */
    private $email;

    /**
     * Roles.
     *
     * @ORM\Column(type="json")
     *
     * @var array
     */
    private $roles = [];

    /**
     * The hashed password.
     *
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * confirmPassword
     */
    private $confirmPassword = '';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinion", mappedBy="user")
     *
     * opinions
     *
     * @var ArrayCollection
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favourites", mappedBy="user")
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
        $this->opinions = new ArrayCollection();
        $this->favourites = new ArrayCollection();
    }

    /**
     * Getter for the Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getNick.
     *
     * @return string
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * setNick.
     *
     * @param string $nick
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }

    /**
     * Getter for the E-mail.
     *
     * @return string|null E-mail
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for the E-mail.
     *
     * @param string $email E-mail
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string User name
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for the Roles.
     *
     * @see UserInterface
     *
     * @return array Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * Setter for the Roles.
     *
     * @param array $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Getter for the Password.
     *
     * @see UserInterface
     *
     * @return string|null Password
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }

    /**
     * Setter for the Password.
     *
     * @param string $password Password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * getConfirmPassword.
     *
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    /**
     * setConfirmPassword.
     *
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @return Collection|Opinion[]
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
            $opinion->setUser($this);
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
            if ($opinion->getUser() === $this) {
                $opinion->setUser(null);
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
            $favourite->setUser($this);
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
            if ($favourite->getUser() === $this) {
                $favourite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * isAdmin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->getRoles());
    }
}
