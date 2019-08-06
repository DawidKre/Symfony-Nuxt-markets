<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends AbstractBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketProduct", mappedBy="category")
     *
     * @var MarketProduct
     */
    private $marketProducts;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->marketProducts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Category
     */
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

    /**
     * @param MarketProduct $marketProduct
     *
     * @return Category
     */
    public function addMarketProduct(MarketProduct $marketProduct): self
    {
        if (!$this->marketProducts->contains($marketProduct)) {
            $this->marketProducts[] = $marketProduct;
            $marketProduct->setCategory($this);
        }

        return $this;
    }

    /**
     * @param MarketProduct $marketProduct
     *
     * @return Category
     */
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
