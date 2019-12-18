<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(type="string", length=255,   unique=true)
     * @Assert\NotBlank
     *      @Assert\Length(
     *      min = 4,
     *      max = 15,
     *      minMessage = "user.username.MinLength",
     *      maxMessage = "user.username.MaxLength"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank()
     *      @Assert\Length(
     *      min = 6,
     *      max = 25,
     *      minMessage = "user.plainPassword.MinLength",
     *      maxMessage = "user.plainPassword.MaxLength"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="user")
     */
    private $products;

    /**
     * @ORM\Column(type="date",  nullable=true)
     * @Assert\NotBlank
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $male;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;


    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $target;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
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

    public function getAge(){
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

    public function getMale(): ?int
    {
        return $this->male;
    }

    public function setMale(int $male): self
    {
        $this->male = $male;

        return $this;
    }

    public function getTarget(): ?int
    {
        return $this->target;
    }

    public function setTarget(int $target): self
    {
        $this->target = $target;

        return $this;
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

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
        // TODO: Implement getSalt() method.
    }




    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
