<?php

namespace App\Controller;

use App\BusinessLogic\Importer\Exception\ImporterException;
use App\BusinessLogic\Importer\Service\ImportService;
use App\Entity\ImporterLog;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScraperController.
 */
class ScraperController extends AbstractController
{
    /**
     * @Route("/scraper", name="scraper")
     *
     * @param ImportService          $importService
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     *
     * @throws ImporterException
     */
    public function index(ImportService $importService, EntityManagerInterface $entityManager): Response
    {
        $importStartDate = new DateTime();
        $importerLogs = $entityManager->getRepository(ImporterLog::class)->getNotImported();
        foreach ($importerLogs as $importerLog) {
            $importService->import($importerLog, $importStartDate);
        }

        return $this->render('scraper/index.html.twig');
    }

    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function home(): Response
    {
        return $this->redirect('/api');
    }
}
