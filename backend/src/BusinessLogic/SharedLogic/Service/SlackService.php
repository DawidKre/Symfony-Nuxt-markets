<?php

namespace App\BusinessLogic\SharedLogic\Service;

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

    /**
     * SlackService constructor.
     *
     * @param SlackClient $slackClient
     */
    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
        $this->message = $this->slackClient->createMessage();
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
        $this->message->setText($text);
        $this->slackClient->sendMessage($this->message);
    }
}
