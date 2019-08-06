<?php

namespace App\BusinessLogic\Scraper\EventSubscriber;

use App\Entity\ImporterLog;
use App\Entity\ScraperLog;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class SuccessScraperLogCreatedSubscriber.
 */
class SuccessScraperLogCreatedSubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::postPersist];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function index(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof ScraperLog) {
            $entityManager = $args->getObjectManager();

            if ($entity->getSuccess()) {
                $importerLog = new ImporterLog();
                $importerLog->setScraperLog($entity);
                $entityManager->persist($importerLog);
                $entityManager->flush();
            }
        }
    }
}
