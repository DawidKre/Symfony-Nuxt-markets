<?php

namespace App\Controller;

use App\BusinessLogic\Scraper\Service\CheckerService;
use App\BusinessLogic\Scraper\Service\ScraperManager;
use App\Entity\Market;
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
    public function index(CheckerService $checkerService, ScraperManager $scraperManager): Response
    {
        dd($scraperManager->scrapeMarkets());
        $market = $this->getDoctrine()->getRepository(Market::class)->findOneBy([]);
        $market->getScraperChecks()->last();
//        $scraper->scrapeMarkets();

        return new Response(['200']);
    }
}
