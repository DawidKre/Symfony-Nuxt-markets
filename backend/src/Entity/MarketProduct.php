<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\BusinessLogic\SharedLogic\Model\EnumTypeName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\MarketProductRepository")
 */
class MarketProduct extends AbstractBaseEntity
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
     * @ORM\Column(type=EnumTypeName::UNIT_TYPE)
     *
     * @var string
     */
    private $unit;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     *
     * @var float
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceMin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceMax;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceAvg;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceDifference;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceMinPrevious;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceMaxPrevious;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     *
     * @var float
     */
    private $priceAvgPrevious;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="marketProducts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Market
     */
    private $market;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="marketProducts")
     *
     * @var Category
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MasterProduct", inversedBy="marketProducts")
     *
     * @var MasterProduct
     */
    private $masterProduct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="marketProduct", orphanRemoval=true)
     *
     * @var Price[]
     */
    private $prices;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    private $isActive;

    /**
     * MarketProduct constructor.
     */
    public function __construct()
    {
        $this->prices = new ArrayCollection();
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
     * @return MarketProduct
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     *
     * @return MarketProduct
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return MarketProduct
     */
    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return MarketProduct
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMin(): float
    {
        return $this->priceMin;
    }

    /**
     * @param float $priceMin
     *
     * @return MarketProduct
     */
    public function setPriceMin(float $priceMin): self
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMax(): float
    {
        return $this->priceMax;
    }

    /**
     * @param float $priceMax
     *
     * @return MarketProduct
     */
    public function setPriceMax(float $priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceAvg(): float
    {
        return $this->priceAvg;
    }

    /**
     * @param float $priceAvg
     *
     * @return MarketProduct
     */
    public function setPriceAvg(float $priceAvg): self
    {
        $this->priceAvg = $priceAvg;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceDifference(): float
    {
        return $this->priceDifference;
    }

    /**
     * @param float $priceDifference
     *
     * @return MarketProduct
     */
    public function setPriceDifference(float $priceDifference): self
    {
        $this->priceDifference = $priceDifference;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceAvgPrevious(): float
    {
        return $this->priceAvgPrevious;
    }

    /**
     * @param float $priceAvgPrevious
     *
     * @return MarketProduct
     */
    public function setPriceAvgPrevious(float $priceAvgPrevious): self
    {
        $this->priceAvgPrevious = $priceAvgPrevious;

        return $this;
    }

    /**
     * @return Market
     */
    public function getMarket(): Market
    {
        return $this->market;
    }

    /**
     * @param Market $market
     *
     * @return MarketProduct
     */
    public function setMarket(Market $market): self
    {
        $this->market = $market;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     *
     * @return MarketProduct
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return MasterProduct|null
     */
    public function getMasterProduct(): ?MasterProduct
    {
        return $this->masterProduct;
    }

    /**
     * @param MasterProduct|null $masterProduct
     *
     * @return MarketProduct
     */
    public function setMasterProduct(?MasterProduct $masterProduct): self
    {
        $this->masterProduct = $masterProduct;

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    /**
     * @param Price $price
     *
     * @return MarketProduct
     */
    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setMarketProduct($this);
        }

        return $this;
    }

    /**
     * @param Price $price
     *
     * @return MarketProduct
     */
    public function removePrice(Price $price): self
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

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @return MarketProduct
     */
    public function setActive(): self
    {
        $this->setIsActive(true);

        return $this;
    }

    /**
     * @return MarketProduct
     */
    public function setInActive(): self
    {
        $this->setIsActive(false);

        return $this;
    }

    /**
     * @param bool|null $isActive
     *
     * @return MarketProduct
     */
    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceMinPrevious(): ?float
    {
        return $this->priceMinPrevious;
    }

    /**
     * @param float $priceMinPrevious
     *
     * @return MarketProduct
     */
    public function setPriceMinPrevious(float $priceMinPrevious): MarketProduct
    {
        $this->priceMinPrevious = $priceMinPrevious;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceMaxPrevious(): ?float
    {
        return $this->priceMaxPrevious;
    }

    /**
     * @param float $priceMaxPrevious
     *
     * @return MarketProduct
     */
    public function setPriceMaxPrevious(float $priceMaxPrevious): MarketProduct
    {
        $this->priceMaxPrevious = $priceMaxPrevious;

        return $this;
    }
}
