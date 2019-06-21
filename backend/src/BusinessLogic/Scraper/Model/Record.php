<?php

namespace App\BusinessLogic\Scraper\Model;

/**
 * Class Record
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
        return array_keys(get_object_vars($this));
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
     * @return Record
     */
    public function setMarket(string $market): Record
    {
        $this->market = $market;

        return $this;
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
     * @return Record
     */
    public function setCategory(string $category): Record
    {
        $this->category = $category;

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
     * @return Record
     */
    public function setUnit(string $unit): Record
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
     * @return Record
     */
    public function setQuantity(float $quantity): Record
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
     * @return Record
     */
    public function setAmount(int $amount): Record
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
     * @return Record
     */
    public function setPriceMin(float $priceMin): Record
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
     * @return Record
     */
    public function setPriceMax(float $priceMax): Record
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
     * @return Record
     */
    public function setPriceAvg(float $priceAvg): Record
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
     * @return Record
     */
    public function setPriceDifference(float $priceDifference): Record
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
     * @return Record
     */
    public function setPriceAvgPrevious(float $priceAvgPrevious): Record
    {
        $this->priceAvgPrevious = $priceAvgPrevious;

        return $this;
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
     * @return Record
     */
    public function setScrapeDate(string $scrapeDate): Record
    {
        $this->scrapeDate = $scrapeDate;

        return $this;
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
     * @return Record
     */
    public function setPriceStartDate(string $priceStartDate): Record
    {
        $this->priceStartDate = $priceStartDate;

        return $this;
    }
}
