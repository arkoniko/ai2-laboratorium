<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\WeatherdataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather_city', requirements: ['city' => '[a-zA-Z]+'])]
    public function city(string $city, LocationRepository $locationRepository, WeatherdataRepository $weatherdataRepository): Response
    {
        $location = $locationRepository->findOneByCity($city);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        $measurements = $weatherdataRepository->findByLocation($location);
        dump($measurements);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
