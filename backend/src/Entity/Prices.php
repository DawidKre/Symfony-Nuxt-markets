<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PricesRepository")
 */
class Prices extends AbstractBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $priceMin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $priceMax;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $priceAvg;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $priceDifference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketProduct", inversedBy="prices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marketProduct;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMarketProduct(): ?MarketProduct
    {
        return $this->marketProduct;
    }

    public function setMarketProduct(?MarketProduct $marketProduct): self
    {
        $this->marketProduct = $marketProduct;

        return $this;
    }
}
