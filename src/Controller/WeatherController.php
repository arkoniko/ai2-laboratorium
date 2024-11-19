<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather_city', requirements: ['country' => '[A-Z]{2}', 'city' => '[a-zA-Z\-]+'])]
    public function city(string $country, string $city, WeatherUtil $weatherUtil): Response
    {

        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if (empty($measurements)) {
            throw $this->createNotFoundException('Weather data not found for the specified location.');
        }


        $location = $measurements[0]->getLocation();

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
