<?php

namespace App\Command;

use App\Repository\CitiesRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:location-id',
    description: 'Get weather data based on provided ID',
)]
class WeatherLocationIdCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private CitiesRepository $citiesRepository;

    public function __construct(WeatherUtil $weatherUtil, CitiesRepository $citiesRepository)
    {
        $this->weatherUtil = $weatherUtil;
        $this->citiesRepository = $citiesRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $io->ask("Enter location ID:");

        if ($id) {

            $city = $this->citiesRepository->find($id);
            $weather = $this->weatherUtil->getWeatherForLocation($city);

            $io->text(sprintf('Weather for %s', $city->getName()));

            $table = new Table($output);
            $table->setHeaders(["ID", "Date", "Temp Night", "Temp Day", "Rain Prob", "Wind Speed"]);

            $rows = [];
            foreach ($weather as $singleWeather) {
                $rows[] = $singleWeather->toArray();
            }

            $table->setRows($rows);
            $table->render();

        } else {
            $io->error("You have to provide location ID!");
        }

        return Command::SUCCESS;
    }
}
