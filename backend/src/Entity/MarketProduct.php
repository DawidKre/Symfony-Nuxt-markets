<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\BusinessLogic\SharedLogic\Model\EnumTypeName;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MarketProductRepository")
 */
class MarketProduct
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
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceMin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceMax;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceAvg;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceDifference;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceAvgPrevious;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="marketProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="marketProducts")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MasterProduct", inversedBy="marketProducts")
     */
    private $masterProduct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Prices", mappedBy="marketProduct", orphanRemoval=true)
     */
    private $prices;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
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

    public function getPriceMin()
    {
        return $this->priceMin;
    }

    public function setPriceMin($priceMin): self
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    public function getPriceMax()
    {
        return $this->priceMax;
    }

    public function setPriceMax($priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    public function getPriceAvg()
    {
        return $this->priceAvg;
    }

    public function setPriceAvg($priceAvg): self
    {
        $this->priceAvg = $priceAvg;

        return $this;
    }

    public function getPriceDifference()
    {
        return $this->priceDifference;
    }

    public function setPriceDifference($priceDifference): self
    {
        $this->priceDifference = $priceDifference;

        return $this;
    }

    public function getPriceAvgPrevious()
    {
        return $this->priceAvgPrevious;
    }

    public function setPriceAvgPrevious($priceAvgPrevious): self
    {
        $this->priceAvgPrevious = $priceAvgPrevious;

        return $this;
    }

    public function getMarket(): ?Market
    {
        return $this->market;
    }

    public function setMarket(?Market $market): self
    {
        $this->market = $market;

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

    public function getMasterProduct(): ?MasterProduct
    {
        return $this->masterProduct;
    }

    public function setMasterProduct(?MasterProduct $masterProduct): self
    {
        $this->masterProduct = $masterProduct;

        return $this;
    }

    /**
     * @return Collection|Prices[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Prices $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setMarketProduct($this);
        }

        return $this;
    }

    public function removePrice(Prices $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getMarketProduct() === $this) {
                $price->setMarketProduct(null);
            }
        }

        return $this;
    }
}
