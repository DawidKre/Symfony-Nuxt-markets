<?php

namespace App\BusinessLogic\SharedLogic\Service;

use App\BusinessLogic\SharedLogic\Model\SlackMessagesType;
use DateTime;
use Http\Client\Exception;
use Nexy\Slack\Client as SlackClient;
use Nexy\Slack\Message;

/**
 * Class SlackService.
 */
class SlackService
{
    /** @var string */
    private const ERROR_MESSAGE = '!!! Error: ';

    /** @var SlackClient */
    private $slackClient;

    /** @var Message */
    private $message;

    /** @var string */
    private $currentDate;

    /**
     * @param SlackClient $slackClient
     *
     * @throws \Exception
     */
    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
        $this->message = $this->slackClient->createMessage();
        $this->currentDate = (new DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @param string $marketName
     * @throws Exception
     */
    public function sendScraperChangesNotFoundMessage(string $marketName): void
    {
        $this->sendSlackMessage($marketName.' -> '.SlackMessagesType::SCRAPER_CHANGES_NOT_FOUND);
    }

    /**
     * @param string $marketName
     *
     * @throws Exception
     */
    public function sendScraperStartScrapingMessage(string $marketName): void
    {
        $this->sendSlackMessage($marketName.' -> '.SlackMessagesType::SCRAPER_START_SCRAPING);
    }

    /**
     * @param string $text
     *
     * @throws Exception
     */
    public function sendMessage(string $text): void
    {
        $this->sendSlackMessage($text);
    }

    /**
     * @param string $errorMessage
     *
     * @throws Exception
     */
    public function sendErrorMessage(string $errorMessage): void
    {
        $text = self::ERROR_MESSAGE.$errorMessage;
        $this->sendSlackMessage($text);
    }

    /**
     * @param string $text
     *
     * @throws Exception
     */
    private function sendSlackMessage(string $text): void
    {
        $this->message->setText("{$text} [{$this->currentDate}]");
        $this->slackClient->sendMessage($this->message);
    }
}
