<?php

namespace App\BusinessLogic\SharedLogic\Service;

use DateTime;
use Http\Client\Exception;
use Nexy\Slack\Client as SlackClient;
use Nexy\Slack\Message;

/**
 * Class SlackService.
 */
class SlackService
{
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
     * @param string $text
     *
     * @throws Exception
     */
    public function sendMessage(string $text): void
    {
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
