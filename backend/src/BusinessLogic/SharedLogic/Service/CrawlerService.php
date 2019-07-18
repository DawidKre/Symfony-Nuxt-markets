<?php

namespace App\BusinessLogic\SharedLogic\Service;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class CrawlerService.
 */
class CrawlerService
{
    private const GET_REQUEST = 'GET';

    /** @var GoutteClient */
    private $client;

    /**
     * SlackService constructor.
     *
     * @param GuzzleClient $guzzleClient
     * @param GoutteClient $client
     */
    public function __construct(GuzzleClient $guzzleClient, GoutteClient $client)
    {
        $this->client = $client;
        $this->client->setClient($guzzleClient);
    }

    /**
     * @param string $url
     *
     * @return Crawler
     */
    public function crawlPage(string $url): Crawler
    {
        return $this->client->request(self::GET_REQUEST, $url);
    }
}
