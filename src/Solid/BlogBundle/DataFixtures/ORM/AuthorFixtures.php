<?php

namespace Solid\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Faker;

class AuthorFixtures extends AbstractFixture implements ContainerAwareInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        $userManager = $this->container->get('fos_user.user_manager');
        for ($i = 1; $i <= 2; $i++)
        {
            $a = $userManager->createUser();
            $a->setUsername($faker->firstName);
            $a->setEmail($faker->email);
            $a->setPlainPassword('password');
            $a->setEnabled(true);
            $a->setRoles(array('ROLE_USER'));
            $this->addReference('author_' . $i, $a);

            $userManager->updateUser($a, true);
        }

        $a = $userManager->createUser();
        $a->setUsername('Test');
        $a->setEmail('test@email.com');
        $a->setPlainPassword('password');
        $a->setEnabled(true);
        $a->setRoles(array('ROLE_USER'));
        $this->addReference('author_' . 3, $a);

        $userManager->updateUser($a, true);
    }

    /**
     *
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

    function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}