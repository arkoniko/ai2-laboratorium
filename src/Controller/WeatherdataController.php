<?php

namespace App\Controller;

use App\Entity\Weatherdata;
use App\Form\WeatherdataType;
use App\Repository\WeatherdataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/weatherdata')]
final class WeatherdataController extends AbstractController
{
    #[Route(name: 'app_weatherdata_index', methods: ['GET'])]
    public function index(WeatherdataRepository $weatherdataRepository): Response
    {
        return $this->render('weatherdata/index.html.twig', [
            'weatherdatas' => $weatherdataRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_weatherdata_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $weatherdatum = new Weatherdata();
        $form = $this->createForm(WeatherdataType::class, $weatherdatum, [
            'validation_groups' => ['create'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($weatherdatum);
            $entityManager->flush();

            return $this->redirectToRoute('app_weatherdata_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weatherdata/new.html.twig', [
            'weatherdatum' => $weatherdatum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weatherdata_show', methods: ['GET'])]
    public function show(Weatherdata $weatherdatum): Response
    {
        return $this->render('weatherdata/show.html.twig', [
            'weatherdatum' => $weatherdatum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_weatherdata_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Weatherdata $weatherdatum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WeatherdataType::class, $weatherdatum, [
            'validation_groups' => ['edit'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_weatherdata_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('weatherdata/edit.html.twig', [
            'weatherdatum' => $weatherdatum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_weatherdata_delete', methods: ['POST'])]
    public function delete(Request $request, Weatherdata $weatherdatum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$weatherdatum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($weatherdatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_weatherdata_index', [], Response::HTTP_SEE_OTHER);
    }
}
