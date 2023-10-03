<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class RestaurantController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Environment $twig, RestaurantRepository $restaurantRepository): Response
    {
        return new Response($twig->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]));
    }

    #[Route('/restaurant/{id}', name: 'restaurant')]
    public function show(Environment $twig, Restaurant $restaurant, SectionRepository $sectionRepository): Response
    {
        return new Response($twig->render(
            '/restaurant/show.html.twig',
            [
                'restaurant' => $restaurant,
                'sections' => $sectionRepository->findBy(['restaurant' => $restaurant]),
                ]
        ));
    }
}
