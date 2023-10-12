<?php

namespace App\EventSubscriber;

use App\Repository\RestaurantRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private restaurantRepository $restaurantRepository;

    public function __construct(Environment $twig, restaurantRepository $restaurantRepository) {
        $this->twig = $twig;
        $this->restaurantRepository = $restaurantRepository;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('restaurants', $this->restaurantRepository->findAll());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
