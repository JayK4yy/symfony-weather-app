<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\WeatherType;
use App\Repository\WeatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weather-crud')]
class WeatherCrudController extends AbstractController
{
    #[Route('/', name: 'app_weather_controller_crud_index', methods: ['GET'])]
    public function index(WeatherRepository $weatherRepository): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_WEATHER_CRUD_INDEX');

        return $this->render('weather_controller_crud/index.html.twig', [
            'weather' => $weatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weather_controller_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WeatherRepository $weatherRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_WEATHER_CRUD_NEW');

        $weather = new Weather();
        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => ['new']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weather_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_controller_crud/new.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_controller_crud_show', methods: ['GET'])]
    public function show(Weather $weather): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_WEATHER_CRUD_SHOW');

        return $this->render('weather_controller_crud/show.html.twig', [
            'weather' => $weather,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weather_controller_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_WEATHER_CRUD_EDIT');

        $form = $this->createForm(WeatherType::class, $weather, [
            'validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $weatherRepository->save($weather, true);

            return $this->redirectToRoute('app_weather_controller_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('weather_controller_crud/edit.html.twig', [
            'weather' => $weather,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weather_controller_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Weather $weather, WeatherRepository $weatherRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_WEATHER_CRUD_DELETE');

        if ($this->isCsrfTokenValid('delete'.$weather->getId(), $request->request->get('_token'))) {
            $weatherRepository->remove($weather, true);
        }

        return $this->redirectToRoute('app_weather_controller_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
