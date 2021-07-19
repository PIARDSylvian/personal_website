<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Post;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        for ($i = 1; $i <= 40; $i++) {
            $post = new Post();
            $post->setSlug('Post-'.$i);
            $post->setTitle('Post '.$i);
            $post->setContent('sdkjfsldkfjlqmskjdfmlskjf');
            $post->setCreatedAt( \DateTimeImmutable::createFromMutable(new \DateTime('NOW')) );
            $post->setActive(true);
            $post->setCategory($this->getReference('category_'. rand(1, 5)));
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
