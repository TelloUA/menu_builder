<?php

namespace App\EntityListener;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Restaurant::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Restaurant::class)]
class RestaurantEntityListener
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {
    }

    public function prePersist(Restaurant $restaurant, LifecycleEventArgs $event): void
    {
        $restaurant->computeSlug($this->slugger);
    }

    public function preUpdate(Restaurant $restaurant, LifecycleEventArgs $event): void
    {
        $restaurant->computeSlug($this->slugger);
    }
}