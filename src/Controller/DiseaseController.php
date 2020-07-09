<?php
/**
 * Disease controller.
 */

namespace App\Controller;

use App\Entity\Disease;
use App\Form\DiseaseType;
use App\Repository\DiseaseRepository;
use App\Service\PersisterService;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/public", name="disease_index", methods={"GET"})
     *
     * @param Request            $request
     * @param DiseaseRepository  $diseaseRepository
     * @param PaginatorInterface $paginator
     *
     * @return Response
     */
    public function index(Request $request, DiseaseRepository $diseaseRepository, PaginatorInterface $paginator): Response
    {
        $diseases = $paginator->paginate(
            $diseaseRepository->findAll(),
            $request->query->getInt('page', 1),
            Disease::LIMIT,
        );

        return $this->render('disease/index.html.twig', [
            'diseases' => $diseases,
        ]);
    }

    /**
     * @Route("/new", name="disease_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request, PersisterService $persisterService): Response
    {
        $disease = new Disease();
        $form = $this->createForm(DiseaseType::class, $disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $persisterService->save($disease);
            $this->addFlash('success', 'disease_added');

            return $this->redirectToRoute('disease_index');
        }

        return $this->render('disease/new.html.twig', [
            'disease' => $disease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/public/{id}", name="disease_show", methods={"GET"})
     *
     * @param Disease $disease
     *
     * @return Response
     */
    public function show(Disease $disease): Response
    {
        return $this->render('disease/show.html.twig', [
            'disease' => $disease,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="disease_edit", methods={"GET","POST"})
     *
     * @param Request $request
     * @param Disease $disease
     *
     * @return Response
     */
    public function edit(Request $request, Disease $disease, DiseaseRepository $diseaseRepository): Response
    {
        $form = $this->createForm(DiseaseType::class, $disease);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diseaseRepository->save($disease);
            $this->addFlash('success', 'disease_edited');

            return $this->redirectToRoute('disease_index');
        }

        return $this->render('disease/edit.html.twig', [
            'disease' => $disease,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="disease_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Disease $disease
     *
     * @return Response
     */
    public function delete(Request $request, Disease $disease, DiseaseRepository $diseaseRepository, PersisterService $persisterService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disease->getId(), $request->request->get('_token'))) {
            $persisterService->remove($disease);
            $this->addFlash('danger', 'disease_deleted');
        }

        return $this->redirectToRoute('disease_index');
    }
}
