<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }

    #[Route('/restaurant/{id}', name: 'restaurant')]
    public function show(Request $request, Restaurant $restaurant, SectionRepository $sectionRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $sectionRepository->getSectionPaginator($restaurant, $offset);
        return $this->render(
            '/restaurant/show.html.twig',
            [
                'restaurant' => $restaurant,
                'sections' => $paginator,
                'previous' => $offset - SectionRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + SectionRepository::PAGINATOR_PER_PAGE),
                ]
        );
    }
}
