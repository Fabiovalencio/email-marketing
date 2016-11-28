<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\DataFixture;

use CodeEmailMKT\Domain\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class UserFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $value){
            $user = new User();
            $user
                ->setName($faker->firstName . ' ' . $faker->lastName)
                ->setEmail($faker->email)
                ->setPlainPassword('123456')
                ->generatePassword();

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 300;
    }
}