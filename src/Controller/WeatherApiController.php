<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{

    public function getWeatherAction(Request $request, WeatherUtil $weatherUtil): Response
    {
        $payload = $request->toArray();
        $country = $payload["country"];
        $city = $payload["city"];
        $type = $payload["type"];
        $twig = $payload["twig"];

        $weather = $weatherUtil->getWeatherForCountryAndCity($country, $city);
        $response = new Response();

        if ($type == null || $type == "json") {
            $weatherJSON = array();
            foreach ($weather as $singleWeather) {
                $weatherJSON[] = $singleWeather->toArray();
            }

            if ($twig == "true") {
                $response->setContent(
                    $this->render('weather_api/weather.json.twig', [
                        'country' => $country,
                        'city' => $city,
                        'weatherArray' => $weatherJSON,
                    ])
                );
            }
            else {
                $response->setContent(json_encode([
                    "country" => $country,
                    "city" => $city,
                    "weather" => $weatherJSON,
                ]));
            }

            $response->headers->set('Content-Type', 'application-json');
        }
        else if ($type == "csv") {
            $weatherJSON = array();

            if ($twig == "true") {
                foreach ($weather as $singleWeather) {
                    $weatherJSON[] = $singleWeather->toArray();
                }

                $response->setContent(
                    $this->render('weather_api/weather.csv.twig', [
                        'country' => $country,
                        'city' => $city,
                        'weatherArray' => $weatherJSON,
                    ])
                );
            }
            else {
                foreach ($weather as $singleWeather) {
                    $weatherJSON[] = implode(',', $singleWeather->toArray());
                }

                $content = implode("\n", $weatherJSON);
                $response->setContent($content);
            }

            $response->headers->set('Content-Type', 'application-csv');
        }
        else {
            $response->setContent(json_encode([
                "error" => "Invalid type"
            ]));
            $response->headers->set('Content-Type', 'application-json');
        }

        return $response;
    }

}
