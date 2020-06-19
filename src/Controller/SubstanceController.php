<?php

namespace App\Controller;

use App\Entity\Substance;
use App\Form\SubstanceType;
use App\Repository\SubstanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/substance")
 */
class SubstanceController extends AbstractController
{
    /**
     * @Route("/public", name="substance_index", methods={"GET"})
     *
     * @param SubstanceRepository $substanceRepository
     *
     * @return Response
     */
    public function index(SubstanceRepository $substanceRepository): Response
    {
        return $this->render('substance/index.html.twig', [
            'substances' => $substanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="substance_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $substance = new Substance();
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($substance);
            $entityManager->flush();
            $this->addFlash('success', 'substance_added_successfully');


            return $this->redirectToRoute('substance_index');
        }

        return $this->render('substance/new.html.twig', [
            'substance' => $substance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/public/{id}", name="substance_show", methods={"GET"})
     *
     * @param Substance $substance
     *
     * @return Response
     */
    public function show(Substance $substance): Response
    {
        return $this->render('substance/show.html.twig', [
            'substance' => $substance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="substance_edit", methods={"GET","POST"})
     *
     * @param Request   $request
     * @param Substance $substance
     *
     * @return Response
     */
    public function edit(Request $request, Substance $substance): Response
    {
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'substance_edited_successfully');


            return $this->redirectToRoute('substance_index');
        }

        return $this->render('substance/edit.html.twig', [
            'substance' => $substance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="substance_delete", methods={"DELETE"})
     *
     * @param Request   $request
     * @param Substance $substance
     *
     * @return Response
     */
    public function delete(Request $request, Substance $substance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$substance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($substance);
            $entityManager->flush();
            $this->addFlash('success', 'substance_removed');

        }

        return $this->redirectToRoute('substance_index');
    }
}
