<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:country-and-city',
    description: 'Get weather data based on country code and city name',
)]
class WeatherCoutryAndCityCommand extends Command
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $countryCode = $io->ask("Enter country code:");
        $cityName = $io->ask("Enter city name:");

        if ($countryCode && $cityName) {

            $weather = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $cityName);

            $io->text(sprintf('Weather for %s, %s', $cityName, $countryCode));

            $table = new Table($output);
            $table->setHeaders(["ID", "Date", "Temp Night", "Temp Day", "Rain Prob", "Wind Speed"]);

            $rows = [];
            foreach ($weather as $singleWeather) {
                $rows[] = $singleWeather->toArray();
            }

            $table->setRows($rows);
            $table->render();

        } else {
            $io->error("You have to provide country code and city name!");
        }

        return Command::SUCCESS;
    }
}
