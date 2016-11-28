<?php

namespace CodeEmailMKT\Infrastructure\Persistence\Doctrine\DataFixture;

use CodeEmailMKT\Domain\Entity\Customer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CustomerFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //$faker = Faker::create();
        foreach ($this->getData() as $key => $value){
            $customer = new Customer();
            $customer
                ->setName($value['name'])
                ->setEmail($value['email']);

            $manager->persist($customer);
            $this->addReference("customer-$key", $customer);
        }
        $manager->flush();
    }

    public function getData(){
        return [
            ['name' => 'Fabio 1', 'email' => 'fabiovalencio@hotmail.com'],
            ['name' => 'Fabio 2', 'email' => 'fabiovalenciocosta@gmail.com'],
            ['name' => 'Fabio 3', 'email' => 'fabiovalencio@hotmail.com'],
            ['name' => 'Fabio 4', 'email' => 'fabiovalenciocosta@gmail.com'],
            ['name' => 'Fabio 5', 'email' => 'fabiovalencio@hotmail.com']
        ];
    }
    public function getOrder()
    {
        return 100;
    }
}