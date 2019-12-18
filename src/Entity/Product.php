<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=12, minMessage="product.name.MinLength", maxMessage="product.name.MaxLength")
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="products")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\DateTime
     * @Assert\GreaterThan("today", message="Field Go On Sale should be greater than today")
     */
    private $goOnSale;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteProducts")
     */
    private $usersLiked;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->usersLiked = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGoOnSale(): ?\DateTimeInterface
    {
        return $this->goOnSale;
    }

    public function setGoOnSale(?\DateTimeInterface $goOnSale): self
    {
        $this->goOnSale = $goOnSale;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersLiked(): Collection
    {
        return $this->usersLiked;
    }

    public function addUsersLiked(User $usersLiked): self
    {
        if (!$this->usersLiked->contains($usersLiked)) {
            $this->usersLiked[] = $usersLiked;
            $usersLiked->addFavoriteProduct($this);
        }

        return $this;
    }

    public function removeUsersLiked(User $usersLiked): self
    {
        if ($this->usersLiked->contains($usersLiked)) {
            $this->usersLiked->removeElement($usersLiked);
            $usersLiked->removeFavoriteProduct($this);
        }

        return $this;
    }




}
