<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\ScraperCheckRepository")
 */
class ScraperCheck extends AbstractBaseEntity
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
     * @ORM\OneToOne(targetEntity="App\Entity\Market", inversedBy="scraperCheck", cascade={"persist", "remove"})
     */
    private $market;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPricesHash(): ?string
    {
        return $this->pricesHash;
    }

    /**
     * @param string|null $pricesHash
     *
     * @return ScraperCheck
     */
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
