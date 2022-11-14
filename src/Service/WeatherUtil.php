<?php
namespace App\Service;

use App\Repository\CitiesRepository;
use App\Repository\WeatherRepository;

class WeatherUtil
{
    private CitiesRepository $citiesRepository;
    private WeatherRepository $weatherRepository;

    public function __construct(CitiesRepository $citiesRepository, WeatherRepository $weatherRepository)
    {
        $this->citiesRepository = $citiesRepository;
        $this->weatherRepository = $weatherRepository;
    }

    public function getWeatherForCountryAndCity($countryName, $cityName) : array
    {
        $cities = $this->citiesRepository->findByCityName($countryName, $cityName);
        return $this->getWeatherForLocation($cities[0]);

    }

    public function getWeatherForLocation($location) : array
    {
        return $this->weatherRepository->findByCity($location);
    }
}