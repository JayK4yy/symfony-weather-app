<?php       // src/Controller/WeatherController.php

namespace App\Controller;

use App\Entity\Cities;
use App\Repository\CitiesRepository;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
//    #[Route('/weather', name: 'app_weather')]
    public function cityAction(Cities $city, WeatherRepository $weatherRepository): Response
    {
        $weather = $weatherRepository->findByCity($city);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weather' => $weather,
        ]);
    }

    public function cityNameAction(
        $cityName,
        $country,
        WeatherRepository $weatherRepository,
        CitiesRepository $citiesRepository): Response
    {
        $cities = $citiesRepository->findByCityName($country, $cityName);

        try {
            $city = $cities[0];
            $weather = $weatherRepository->findByCity($cities[0]);

            return $this->render('weather/city.html.twig', [
                'city' => $city,
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
