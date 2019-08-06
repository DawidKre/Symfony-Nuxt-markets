<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\PriceRepository")
 */
class Price extends AbstractBaseEntity
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     *
     * @var float
     */
    private $priceMin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     *
     * @var float
     */
    private $priceMax;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     *
     * @var float
     */
    private $priceAvg;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     *
     * @var float
     *
     * @var float
     */
    private $priceDifference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketProduct", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marketProduct;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTimeInterface
     */
    private $startDate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Price
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
     * @return Price
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
     * @return Price
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
     * @return Price
     */
    public function setPriceDifference(float $priceDifference): self
    {
        $this->priceDifference = $priceDifference;

        return $this;
    }

    /**
     * @return MarketProduct
     */
    public function getMarketProduct(): MarketProduct
    {
        return $this->marketProduct;
    }

    /**
     * @param MarketProduct $marketProduct
     *
     * @return Price
     */
    public function setMarketProduct(MarketProduct $marketProduct): self
    {
        $this->marketProduct = $marketProduct;

        return $this;
    }

    /**
     * @param DateTimeInterface $startDate
     *
     * @return Price
     */
    public function setStartDate(DateTimeInterface $startDate): Price
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartDate(): DateTimeInterface
    {
        return $this->startDate;
    }
}
