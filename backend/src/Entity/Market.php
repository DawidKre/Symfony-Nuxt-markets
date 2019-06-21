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

    public function __construct()
    {
        $this->marketProducts = new ArrayCollection();
        $this->scraperLogs = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getPricesUrl(): ?string
    {
        return $this->pricesUrl;
    }

    public function setPricesUrl(string $pricesUrl): self
    {
        $this->pricesUrl = $pricesUrl;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

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

    public function addMarketProduct(MarketProduct $marketProduct): self
    {
        if (!$this->marketProducts->contains($marketProduct)) {
            $this->marketProducts[] = $marketProduct;
            $marketProduct->setMarket($this);
        }

        return $this;
    }

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

    public function addScraperLog(ScraperLog $scraperLog): self
    {
        if (!$this->scraperLogs->contains($scraperLog)) {
            $this->scraperLogs[] = $scraperLog;
            $scraperLog->setMarket($this);
        }

        return $this;
    }

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
}
