<?php

namespace App\DataFixtures;

use App\Entity\Market;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * MarketFixtures Class
 */
class MarketFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getMarketsData() as $marketData) {
            $market = new Market();
            $market->setName($marketData['name']);
            $market->setUrl($marketData['url']);
            $market->setPricesUrl($marketData['prices_url']);
            $market->setAddress($marketData['address']);
            $market->setDescription($marketData['description']);
            $market->setLogo($marketData['logo']);

            $manager->persist($market);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getMarketsData(): array
    {
        return [
            [
                'name' => 'Elizówka',
                'url'  => 'https://www.elizowka.pl/',
                'prices_url' => 'https://www.elizowka.pl/notowania-cen-produktow',
                'address' => 'Elizówka 65, 21-003 Ciecierzyn, Polska',
                'description' => 'Lubelski Rynek Hurtowy S.A.',
                'logo' => 'https://www.elizowka.pl/img/1/logo.png',
            ],
        ];
    }
}
