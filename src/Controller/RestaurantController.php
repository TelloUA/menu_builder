<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use App\Repository\ReviewRepository;
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

    #[Route('/restaurant/{slug}', name: 'restaurant')]
    public function show(
        Request $request,
        Restaurant $restaurant,
        SectionRepository $sectionRepository,
        ReviewRepository $reviewRepository
    ): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $reviewRepository->getReviewPaginator($restaurant, $offset);
        return $this->render(
            '/restaurant/show.html.twig',
            [
                'restaurant' => $restaurant,
                'sections' => $sectionRepository->findBy(['restaurant' => $restaurant, 'isActive' => true]),
                'reviews' => $paginator,
                'previous' => $offset - ReviewRepository::PAGINATOR_PER_PAGE,
                'next' => min(count($paginator), $offset + ReviewRepository::PAGINATOR_PER_PAGE),
                ]
        );
    }
}
