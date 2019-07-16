<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 *
 * @ORM\Entity(repositoryClass="App\Repository\MarketRepository")
 */
class Market extends AbstractBaseEntity
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
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pricesUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketProduct", mappedBy="market")
     */
    private $marketProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScraperLog", mappedBy="market")
     */
    private $scraperLogs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ScraperCheck", mappedBy="market", cascade={"persist", "remove"})
     */
    private $scraperCheck;

    /**
     * Market constructor.
     */
    public function __construct()
    {
        $this->marketProducts = new ArrayCollection();
        $this->scraperLogs = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Market
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Market
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPricesUrl(): ?string
    {
        return $this->pricesUrl;
    }

    /**
     * @param string $pricesUrl
     *
     * @return Market
     */
    public function setPricesUrl(string $pricesUrl): self
    {
        $this->pricesUrl = $pricesUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Market
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return Market
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     *
     * @return Market
     */
    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|MarketProduct[]
     */
    public function getMarketProducts(): Collection
    {
        return $this->marketProducts;
    }

    /**
     * @param MarketProduct $marketProduct
     *
     * @return Market
     */
    public function addMarketProduct(MarketProduct $marketProduct): self
    {
        if (!$this->marketProducts->contains($marketProduct)) {
            $this->marketProducts[] = $marketProduct;
            $marketProduct->setMarket($this);
        }

        return $this;
    }

    /**
     * @param MarketProduct $marketProduct
     *
     * @return Market
     */
    public function removeMarketProduct(MarketProduct $marketProduct): self
    {
        if ($this->marketProducts->contains($marketProduct)) {
            $this->marketProducts->removeElement($marketProduct);
            // set the owning side to null (unless already changed)
            if ($marketProduct->getMarket() === $this) {
                $marketProduct->setMarket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ScraperLog[]
     */
    public function getScraperLogs(): Collection
    {
        return $this->scraperLogs;
    }

    /**
     * @param ScraperLog $scraperLog
     *
     * @return Market
     */
    public function addScraperLog(ScraperLog $scraperLog): self
    {
        if (!$this->scraperLogs->contains($scraperLog)) {
            $this->scraperLogs[] = $scraperLog;
            $scraperLog->setMarket($this);
        }

        return $this;
    }

    /**
     * @param ScraperLog $scraperLog
     *
     * @return Market
     */
    public function removeScraperLog(ScraperLog $scraperLog): self
    {
        if ($this->scraperLogs->contains($scraperLog)) {
            $this->scraperLogs->removeElement($scraperLog);
            // set the owning side to null (unless already changed)
            if ($scraperLog->getMarket() === $this) {
                $scraperLog->setMarket(null);
            }
        }

        return $this;
    }

    /**
     * @return ScraperCheck|null
     */
    public function getScraperCheck(): ?ScraperCheck
    {
        return $this->scraperCheck;
    }

    /**
     * @param ScraperCheck|null $scraperCheck
     *
     * @return Market
     */
    public function setScraperCheck(?ScraperCheck $scraperCheck): self
    {
        $this->scraperCheck = $scraperCheck;

        // set (or unset) the owning side of the relation if necessary
        $newMarket = null === $scraperCheck ? null : $this;
        if ($newMarket !== $scraperCheck->getMarket()) {
            $scraperCheck->setMarket($newMarket);
        }

        return $this;
    }
}
