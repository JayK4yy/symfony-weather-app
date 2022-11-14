<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Repository\CitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    public function cityAction(Cities $city, WeatherUtil $weatherUtil): Response
    {
        $weather = $weatherUtil->getWeatherForLocation($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weather' => $weather,
        ]);
    }

    public function cityNameAction($cityName, $country, CitiesRepository $citiesRepository, WeatherUtil $weatherUtil): Response
    {
        try {
            $cities = $citiesRepository->findByCityName($country, $cityName);
            $weather = $weatherUtil->getWeatherForCountryAndCity($country, $cityName);

            return $this->render('weather/city.html.twig', [
                'city' => $cities[0],
                'weather' => $weather,
            ]);

        } catch (\ErrorException) {
            return $this->render('weather/no-city.html.twig', [
                'city' => $cityName,
                'country' => $country
            ]);
        }
    }
}
