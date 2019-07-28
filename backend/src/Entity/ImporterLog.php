<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImporterLogRepository")
 */
class ImporterLog extends AbstractBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ScraperLog", inversedBy="importerLog", cascade={"persist", "remove"})
     */
    private $scraperLog;

    /**
     * @ORM\Column(type="boolean")
     */
    private $success = false;

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
     * @return ScraperLog
     */
    public function getScraperLog(): ScraperLog
    {
        return $this->scraperLog;
    }

    /**
     * @param ScraperLog|null $scraperLog
     *
     * @return ImporterLog
     */
    public function setScraperLog(ScraperLog $scraperLog): self
    {
        $this->scraperLog = $scraperLog;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return ImporterLog
     */
    public function setSuccess(bool $success): self
    {
        $this->success = $success;

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
     * @return ImporterLog
     */
    public function setErrorMessage(?string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
