<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketProduct", mappedBy="category")
     */
    private $marketProducts;

    public function __construct()
    {
        $this->marketProducts = new ArrayCollection();
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
     * @return Collection|MarketProduct[]
     */
    public function getMarketProducts(): Collection
    {
        return $this->marketProducts;
    }

    public function addMarketProduct(MarketProduct $marketProduct): self
    {
        if (!$this->marketProducts->contains($marketProduct)) {
            $this->marketProducts[] = $marketProduct;
            $marketProduct->setCategory($this);
        }

        return $this;
    }

    public function removeMarketProduct(MarketProduct $marketProduct): self
    {
        if ($this->marketProducts->contains($marketProduct)) {
            $this->marketProducts->removeElement($marketProduct);
            // set the owning side to null (unless already changed)
            if ($marketProduct->getCategory() === $this) {
                $marketProduct->setCategory(null);
            }
        }

        return $this;
    }
}
