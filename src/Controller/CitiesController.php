<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Form\CitiesType;
use App\Repository\CitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cities-crud')]
class CitiesController extends AbstractController
{
    #[Route('/', name: 'app_cities_index', methods: ['GET'])]
    public function index(CitiesRepository $citiesRepository): Response
    {
        return $this->render('cities/index.html.twig', [
            'cities' => $citiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CitiesRepository $citiesRepository): Response
    {
        $city = new Cities();
        $form = $this->createForm(CitiesType::class, $city, [
            'validation_groups' => ['new']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citiesRepository->save($city, true);

            return $this->redirectToRoute('app_cities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cities/new.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cities_show', methods: ['GET'])]
    public function show(Cities $city): Response
    {
        return $this->render('cities/show.html.twig', [
            'city' => $city,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cities $city, CitiesRepository $citiesRepository): Response
    {
        $form = $this->createForm(CitiesType::class, $city, [
            'validation_groups' => ['edit']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citiesRepository->save($city, true);

            return $this->redirectToRoute('app_cities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cities/edit.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cities_delete', methods: ['POST'])]
    public function delete(Request $request, Cities $city, CitiesRepository $citiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $citiesRepository->remove($city, true);
        }

        return $this->redirectToRoute('app_cities_index', [], Response::HTTP_SEE_OTHER);
    }
}
