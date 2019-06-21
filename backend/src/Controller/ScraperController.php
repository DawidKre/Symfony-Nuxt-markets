<?php

namespace App\Controller;

use App\BusinessLogic\Scraper\Service\ScraperManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**  */
class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="sraper")
     *
     * @param ScraperManager $scraper
     *
     * @return Response
     * @throws \League\Csv\CannotInsertRecord
     */
    public function index(ScraperManager $scraper): Response
    {
        $scraper->scrapeMarkets();

        return new Response(['200']);
    }
}
