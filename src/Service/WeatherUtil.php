<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Weatherdata;
use App\Repository\LocationRepository;
use App\Repository\WeatherdataRepository;

class WeatherUtil
{
    private LocationRepository $locationRepository;
    private WeatherdataRepository $weatherdataRepository;

    public function __construct(
        LocationRepository $locationRepository,
        WeatherdataRepository $weatherdataRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->weatherdataRepository = $weatherdataRepository;
    }

    /**
     * @return Weatherdata[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        // Pobierz dane pogodowe dla podanej lokalizacji
        return $this->weatherdataRepository->findByLocation($location);
    }

    /**
     * @return Weatherdata[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        // Pobierz lokalizację na podstawie kodu kraju i miasta
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if (!$location) {
            // Zwróć pustą tablicę, jeśli lokalizacja nie istnieje
            return [];
        }

        // Pobierz dane pogodowe dla znalezionej lokalizacji
        return $this->weatherdataRepository->findByLocation($location);
    }
}
