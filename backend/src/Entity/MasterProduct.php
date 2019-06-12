<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\BusinessLogic\SharedLogic\Model\EnumTypeName;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MasterProductRepository")
 */
class MasterProduct
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
     * @ORM\Column(type=EnumTypeName::UNIT_TYPE)
     */
    private $unit;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketProduct", mappedBy="masterProduct")
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
            $marketProduct->setMasterProduct($this);
        }

        return $this;
    }

    public function removeMarketProduct(MarketProduct $marketProduct): self
    {
        if ($this->marketProducts->contains($marketProduct)) {
            $this->marketProducts->removeElement($marketProduct);
            // set the owning side to null (unless already changed)
            if ($marketProduct->getMasterProduct() === $this) {
                $marketProduct->setMasterProduct(null);
            }
        }

        return $this;
    }
}
