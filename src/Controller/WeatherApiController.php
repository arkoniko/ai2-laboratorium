<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class WeatherApiController extends AbstractController
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response {
        // Pobierz dane pogodowe za pomocą WeatherUtil
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if (empty($measurements)) {
            return $this->json([
                'error' => 'No weather data found for the specified location.',
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Obsługa formatu JSON
        if ($format === 'json') {
            if ($twig) {
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }

            return $this->json([
                'city' => $city,
                'country' => $country,
                'measurements' => array_map(fn($m) => [
                    'date' => $m->getTimestamp()->format('Y-m-d'),
                    'celsius' => $m->getTemperatureCelsius(),
                    'fahrenheit' => $m->getFahrenheit(),
                ], $measurements),
            ]);
        }

        // Obsługa formatu CSV
        if ($format === 'csv') {
            if ($twig) {
                $response = $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
                $response->headers->set('Content-Type', 'text/csv');
                $response->headers->set('Content-Disposition', 'attachment; filename="weather.csv"');
                return $response;
            }

            $csvLines = ['city,country,date,celsius,fahrenheit'];

            foreach ($measurements as $m) {
                $csvLines[] = implode(',', [
                    $city,
                    $country,
                    $m->getTimestamp()->format('Y-m-d'),
                    $m->getTemperatureCelsius(),
                    $m->getFahrenheit(),
                ]);
            }

            $csvContent = implode("\r\n", $csvLines);

            return new Response($csvContent, Response::HTTP_OK, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="weather.csv"',
            ]);
        }

        // Obsługa nieprawidłowego formatu
        return $this->json([
            'error' => 'Invalid format. Supported formats: json, csv.',
        ], JsonResponse::HTTP_BAD_REQUEST);
    }
}
