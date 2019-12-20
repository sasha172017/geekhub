<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="user.email.taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 6,
     *      max = 20,
     *      minMessage = "user.plainPassword.MinLength",
     *      maxMessage = "user.plainPassword.MaxLength"
     * )
     *  @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$",
     *     message = "user.plainPassword.regex"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255,   unique=true)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 6,
     *      max = 15,
     *      minMessage = "user.name.MinLength",
     *      maxMessage = "user.name.MaxLength"
     * )

     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="user")
     */
    private $products;

    /**
     * @ORM\Column(type="date",  nullable=true)
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="user.male.type"
     * )
     */
    private $male;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="usersLiked")
     */
    private $favoriteProducts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="LikedUsers")
     */
    private $favoriteUsers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteUsers")
     */
    private $LikedUsers;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->favoriteProducts = new ArrayCollection();
        $this->favoriteUsers = new ArrayCollection();
        $this->LikedUsers = new ArrayCollection();
        $this->roles = array('ROLE_USER');
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    public function getAge()
    {
        $now = new \DateTime('now');
        $age = $this->getDateOfBirth();
        $difference = $now->diff($age);
        return $difference->y;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getMale()
    {
        return $this->male;
    }

    public function setMale(int $male): self
    {
        $this->male = $male;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return (string) $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
     * @return Collection|Product[]
     */
    public function getFavoriteProducts(): Collection
    {
        return $this->favoriteProducts;
    }

    public function addFavoriteProduct(Product $favoriteProduct): self
    {
        if (!$this->favoriteProducts->contains($favoriteProduct)) {
            $this->favoriteProducts[] = $favoriteProduct;
        }

        return $this;
    }

    public function removeFavoriteProduct(Product $favoriteProduct): self
    {
        if ($this->favoriteProducts->contains($favoriteProduct)) {
            $this->favoriteProducts->removeElement($favoriteProduct);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function addFavoriteUser(self $favoriteUser): self
    {
        if (!$this->favoriteUsers->contains($favoriteUser)) {
            $this->favoriteUsers[] = $favoriteUser;
        }

        return $this;
    }

    public function removeFavoriteUser(self $favoriteUser): self
    {
        if ($this->favoriteUsers->contains($favoriteUser)) {
            $this->favoriteUsers->removeElement($favoriteUser);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getLikedUsers(): Collection
    {
        return $this->LikedUsers;
    }

    public function addLikedUser(self $likedUser): self
    {
        if (!$this->LikedUsers->contains($likedUser)) {
            $this->LikedUsers[] = $likedUser;
            $likedUser->addFavoriteUser($this);
        }

        return $this;
    }

    public function removeLikedUser(self $likedUser): self
    {
        if ($this->LikedUsers->contains($likedUser)) {
            $this->LikedUsers->removeElement($likedUser);
            $likedUser->removeFavoriteUser($this);
        }

        return $this;
    }
}