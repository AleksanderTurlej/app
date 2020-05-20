<?php

namespace App\Controller;

use App\Entity\Disease;
use App\Form\DiseaseType;
use App\Repository\DiseaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/disease")
 */
class DiseaseController extends AbstractController
{
    /**
     * @Route("/", name="disease_index", methods={"GET"})
     */
    public function index(DiseaseRepository $diseaseRepository): Response
    {
        return $this->render('disease/index.html.twig', [
            'diseases' => $diseaseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="disease_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $disease = new Disease();
        $form = $this->createForm(DiseaseType::class, $disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($disease);
            $entityManager->flush();

            return $this->redirectToRoute('disease_index');
        }

        return $this->render('disease/new.html.twig', [
            'disease' => $disease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="disease_show", methods={"GET"})
     */
    public function show(Disease $disease): Response
    {
        return $this->render('disease/show.html.twig', [
            'disease' => $disease,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="disease_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Disease $disease): Response
    {
        $form = $this->createForm(DiseaseType::class, $disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disease_index');
        }

        return $this->render('disease/edit.html.twig', [
            'disease' => $disease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="disease_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Disease $disease): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disease->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($disease);
            $entityManager->flush();
        }

        return $this->redirectToRoute('disease_index');
    }
}
