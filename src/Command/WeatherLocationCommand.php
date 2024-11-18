<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:location',
    description: 'Retrieve weather forecast for a given location ID.',
)]
class WeatherLocationCommand extends Command
{
    private LocationRepository $locationRepository;
    private WeatherUtil $weatherUtil;

    public function __construct(LocationRepository $locationRepository, WeatherUtil $weatherUtil)
    {
        $this->locationRepository = $locationRepository;
        $this->weatherUtil = $weatherUtil;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'ID of the location to retrieve weather for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $locationId = $input->getArgument('id');

        $location = $this->locationRepository->find($locationId);

        if (!$location) {
            $io->error(sprintf('Location with ID %d not found.', $locationId));
            return Command::FAILURE;
        }

        $measurements = $this->weatherUtil->getWeatherForLocation($location);

        $io->writeln(sprintf('Location: %s', $location->getCity()));

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
