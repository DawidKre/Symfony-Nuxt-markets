<?php

namespace App\Controller;

use App\BusinessLogic\Importer\Service\ImportService;
use App\Entity\ImporterLog;
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
     * @Route("/scraper", name="sraper")
     *
     * @param ImportService $importService
     * @return JsonResponse
     *
     */
    public function index(ImportService $importService, EntityManagerInterface $entityManager): JsonResponse
    {
        $importerLogs = $entityManager->getRepository(ImporterLog::class)->getNotImported();

        foreach ($importerLogs as $importerLog) {
            $importService->import($importerLog);
        }

        return new JsonResponse(['status' => 'success']);
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
