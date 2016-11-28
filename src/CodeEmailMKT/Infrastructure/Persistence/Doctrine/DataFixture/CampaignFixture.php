<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\DataFixture;

use CodeEmailMKT\Domain\Entity\Campaign;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CampaignFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $key => $value){
            $campaign = new Campaign();
            $campaign
                ->setName($faker->country)
                ->setSubject($faker->sentence(5))
                ->setTemplate("<p>Olá %recipient.full_name%, </p><p>{$faker->paragraph(2)}</p><p><a href='https://www.google.com.br/?q=email+marketing'>E-mail marketing</a></p>");

            $manager->persist($campaign);
            $this->addReference("campaign-$key", $campaign);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 100;
    }
}