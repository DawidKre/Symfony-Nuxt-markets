<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScraperLogRepository")
 */
class ScraperLog extends AbstractBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="scraperLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $market;

    /**
     * @ORM\Column(type="boolean")
     */
    private $success;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $csvFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $errorMessage;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Market|null
     */
    public function getMarket(): ?Market
    {
        return $this->market;
    }

    /**
     * @param Market|null $market
     *
     * @return ScraperLog
     */
    public function setMarket(?Market $market): self
    {
        $this->market = $market;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return ScraperLog
     */
    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCsvFile(): ?string
    {
        return $this->csvFile;
    }

    /**
     * @param string|null $csvFile
     *
     * @return ScraperLog
     */
    public function setCsvFile(?string $csvFile): self
    {
        $this->csvFile = $csvFile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string|null $errorMessage
     *
     * @return ScraperLog
     */
    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
