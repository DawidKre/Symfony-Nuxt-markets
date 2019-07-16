<?php

namespace App\BusinessLogic\SharedLogic\Service;

use Http\Client\Exception;
use Nexy\Slack\Client as SlackClient;

/**
 * Class SlackService.
 */
class SlackService
{
    /** @var SlackClient */
    private $slackClient;

    /**
     * SlackService constructor.
     * @param SlackClient $slackClient
     */
    public function __construct(SlackClient $slackClient)
    {
        $this->slackClient = $slackClient;
    }

    /**
     * @param string $text
     *
     * @throws Exception
     */
    public function sendMessage(string $text): void
    {
        $message = $this->slackClient->createMessage();
        $message->setText($text);

        $this->slackClient->sendMessage($message);
    }
}
