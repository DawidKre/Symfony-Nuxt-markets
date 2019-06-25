<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ScraperCheckRepository")
 */
class ScraperCheck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pricesHash;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="scraperChecks")
     */
    private $market;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPricesHash(): ?string
    {
        return $this->pricesHash;
    }

    public function setPricesHash(?string $pricesHash): self
    {
        $this->pricesHash = $pricesHash;

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
}
