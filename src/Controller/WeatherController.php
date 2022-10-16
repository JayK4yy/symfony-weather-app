<?php       // src/Controller/WeatherController.php

namespace App\Controller;

use App\Entity\Cities;
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
}
