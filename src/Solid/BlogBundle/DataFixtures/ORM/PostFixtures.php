<?php

namespace Solid\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Solid\BlogBundle\Entity\Post;
use Faker;

class PostFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 100; $i++)
        {
            $a = new Post();
            $a->setAuthor($this->getReference('author_' . rand(1,3)));
            $a->setName($faker->realText(100));
            $a->setIntro($faker->realText(200));
            $a->setContent($faker->realText(500));
            $a->setCategory($faker->randomElement(array('Category 1', 'Category 2')));

            $manager->persist($a);
        }

        $manager->flush();
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

}