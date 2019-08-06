<?php

namespace App\BusinessLogic\Scraper\Model;

/**
 * Class Record.
 */
class Record implements RecordInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $market;

    /** @var string */
    private $category;

    /** @var string */
    private $unit;

    /** @var string */
    private $quantity;

    /** @var string */
    private $amount;

    /** @var string */
    private $priceMin;

    /** @var string */
    private $priceMax;

    /** @var string */
    private $priceAvg;

    /** @var string */
    private $priceDifference;

    /** @var string */
    private $priceDifferencePrevious;

    /** @var string */
    private $scrapeDate;

    /** @var string */
    private $priceStartDate;

    /**
     * @return array
     */
    public function getAsArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return array
     */
    public function getParametersAsArray(): array
    {
        return array_keys($this->getAsArray());
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
     * @return Record
     */
    public function setName(string $name): Record
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getMarket(): string
    {
        return $this->market;
    }

    /**
     * @param string $market
     */
    public function setMarket(string $market): void
    {
        $this->market = $market;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
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
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return (float) $this->quantity;
    }

    /**
     * @param float $quantity
     */
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return (int) $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getPriceMin(): float
    {
        return (float) $this->priceMin;
    }

    /**
     * @param float $priceMin
     */
    public function setPriceMin(float $priceMin): void
    {
        $this->priceMin = $priceMin;
    }

    /**
     * @return float
     */
    public function getPriceMax(): float
    {
        return (float) $this->priceMax;
    }

    /**
     * @param float $priceMax
     */
    public function setPriceMax(float $priceMax): void
    {
        $this->priceMax = $priceMax;
    }

    /**
     * @return float
     */
    public function getPriceAvg(): float
    {
        return (float) $this->priceAvg;
    }

    /**
     * @param float $priceAvg
     */
    public function setPriceAvg(float $priceAvg): void
    {
        $this->priceAvg = $priceAvg;
    }

    /**
     * @return float
     */
    public function getPriceDifference(): float
    {
        return (float) $this->priceDifference;
    }

    /**
     * @param float $priceDifference
     */
    public function setPriceDifference(float $priceDifference): void
    {
        $this->priceDifference = $priceDifference;
    }

    /**
     * @return float
     */
    public function getPriceDifferencePrevious(): float
    {
        return (float) $this->priceDifferencePrevious;
    }

    /**
     * @param float $priceDifferencePrevious
     */
    public function setPriceDifferencePrevious(float $priceDifferencePrevious): void
    {
        $this->priceDifferencePrevious = $priceDifferencePrevious;
    }

    /**
     * @return string
     */
    public function getScrapeDate(): string
    {
        return $this->scrapeDate;
    }

    /**
     * @param string $scrapeDate
     */
    public function setScrapeDate(string $scrapeDate): void
    {
        $this->scrapeDate = $scrapeDate;
    }

    /**
     * @return string
     */
    public function getPriceStartDate(): string
    {
        return $this->priceStartDate;
    }

    /**
     * @param string $priceStartDate
     */
    public function setPriceStartDate(string $priceStartDate): void
    {
        $this->priceStartDate = $priceStartDate;
    }
}
