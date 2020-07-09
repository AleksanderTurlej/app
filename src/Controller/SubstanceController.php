<?php
/**
 * Substance controller.
 */

namespace App\Controller;

use App\Entity\Substance;
use App\Form\SubstanceType;
use App\Repository\SubstanceRepository;
use App\Service\PersisterService;
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
     */
    public function index(SubstanceRepository $substanceRepository): Response
    {
        return $this->render('substance/index.html.twig', [
            'substances' => $substanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="substance_new", methods={"GET","POST"})
     */
    public function new(Request $request, PersisterService $persisterService): Response
    {
        $substance = new Substance();
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persisterService->save($substance);
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
     */
    public function show(Substance $substance): Response
    {
        return $this->render('substance/show.html.twig', [
            'substance' => $substance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="substance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Substance $substance, PersisterService $persisterService): Response
    {
        $form = $this->createForm(SubstanceType::class, $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persisterService->save($substance);
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
     */
    public function delete(Request $request, Substance $substance, PersisterService $persisterService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$substance->getId(), $request->request->get('_token'))) {
            $persisterService->remove($substance);
            $this->addFlash('danger', 'substance_removed');
        }

        return $this->redirectToRoute('substance_index');
    }
}
