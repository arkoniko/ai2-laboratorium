<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Retrieve weather forecast for a given country code and city name.',
)]
class WeatherCountryCityCommand extends Command
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'Country code (e.g., "PL", "US")')
            ->addArgument('city', InputArgument::REQUIRED, 'City name (e.g., "Warsaw", "New York")');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $country = $input->getArgument('country');
        $city = $input->getArgument('city');

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if (empty($measurements)) {
            $io->error(sprintf('No weather data found for country "%s" and city "%s".', $country, $city));
            return Command::FAILURE;
        }

        $location = $measurements[0]->getLocation();

        $io->writeln(sprintf('Location: %s, %s', $location->getCity(), $location->getCountry()));

        foreach ($measurements as $measurement) {
            $io->writeln(sprintf(
                "\t%s: %s°C",
                $measurement->getTimestamp()->format('Y-m-d'),
                $measurement->getTemperatureCelsius()
            ));
        }

        $io->success('Weather forecast retrieved successfully.');

        return Command::SUCCESS;
    }
}
