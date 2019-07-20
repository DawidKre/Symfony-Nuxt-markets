<?php

namespace App\BusinessLogic\Scraper\EventSubscriber;

use App\Entity\Market;
use App\Entity\ScraperCheck;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class CreateMarketScraperCheckSubscriber.
 */
class CreateMarketScraperCheckSubscriber implements EventSubscriber
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

        if ($entity instanceof Market) {
            $entityManager = $args->getObjectManager();
            $scraperCheck = new ScraperCheck();
            $scraperCheck->setMarket($entity);

            $entityManager->persist($scraperCheck);
            $entityManager->flush();
        }
    }
}