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
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Market", inversedBy="scraperLogs")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Market
     */
    private $market;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $success;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $csvFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $errorMessage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ImporterLog", mappedBy="scraperLog", cascade={"persist", "remove"})
     *
     * @var ImporterLog
     */
    private $importerLog;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Market
     */
    public function getMarket(): Market
    {
        return $this->market;
    }

    /**
     * @param Market $market
     *
     * @return ScraperLog
     */
    public function setMarket(Market $market): self
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

    /**
     * @return ImporterLog
     */
    public function getImporterLog(): ImporterLog
    {
        return $this->importerLog;
    }

    /**
     * @param ImporterLog $importerLog
     *
     * @return ScraperLog
     */
    public function setImporterLog(ImporterLog $importerLog): self
    {
        $this->importerLog = $importerLog;

        // set (or unset) the owning side of the relation if necessary
        $newScraperLog = null === $importerLog ? null : $this;
        if ($newScraperLog !== $importerLog->getScraperLog()) {
            $importerLog->setScraperLog($newScraperLog);
        }

        return $this;
    }
}
