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

    /** @var float */
    private $quantity;

    /** @var int */
    private $amount;

    /** @var float */
    private $priceMin;

    /** @var float */
    private $priceMax;

    /** @var float */
    private $priceAvg;

    /** @var float */
    private $priceDifference;

    /** @var float */
    private $priceAvgPrevious;

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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return void
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
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return void
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
        return $this->priceMin;
    }

    /**
     * @param float $priceMin
     *
     * @return void
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
        return $this->priceMax;
    }

    /**
     * @param float $priceMax
     *
     * @return void
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
        return $this->priceAvg;
    }

    /**
     * @param float $priceAvg
     *
     * @return void
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
        return $this->priceDifference;
    }

    /**
     * @param float $priceDifference
     *
     * @return void
     */
    public function setPriceDifference(float $priceDifference): void
    {
        $this->priceDifference = $priceDifference;
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
     * @return void
     */
    public function setPriceAvgPrevious(float $priceAvgPrevious): void
    {
        $this->priceAvgPrevious = $priceAvgPrevious;
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
     *
     * @return void
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
     *
     * @return void
     */
    public function setPriceStartDate(string $priceStartDate): void
    {
        $this->priceStartDate = $priceStartDate;
    }
}
