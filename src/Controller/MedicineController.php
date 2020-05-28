<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Form\MedicineType;
use App\Repository\MedicineRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medicine")
 */
class MedicineController extends AbstractController
{
    /**
     * @Route("/", name="medicine_index", methods={"GET"})
     *
     * @param Request            $request
     * @param MedicineRepository $medicineRepository
     *
     * @return Response
     */
    public function index(Request $request, MedicineRepository $medicineRepository, PaginatorInterface $paginator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $medicines = $paginator->paginate(
            $medicineRepository->search($request),
            $request->query->getInt('page', 1),
            Medicine::LIMIT,
        );


        return $this->render('medicine/index.html.twig', [
            'medicines' => $medicines,
        ]);
    }

    /**
     * @Route("/new", name="medicine_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $medicine = new Medicine();
        $form = $this->createForm(MedicineType::class, $medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicine);
            $entityManager->flush();

            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('medicine/new.html.twig', [
            'medicine' => $medicine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medicine_show", methods={"GET"})
     *
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function show(Medicine $medicine): Response
    {
        return $this->render('medicine/show.html.twig', [
            'medicine' => $medicine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medicine_edit", methods={"GET","POST"})
     *
     * @param Request  $request
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function edit(Request $request, Medicine $medicine): Response
    {
        $form = $this->createForm(MedicineType::class, $medicine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('medicine/edit.html.twig', [
            'medicine' => $medicine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medicine_delete", methods={"DELETE"})
     *
     * @param Request  $request
     * @param Medicine $medicine
     *
     * @return Response
     */
    public function delete(Request $request, Medicine $medicine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medicine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medicine_index');
    }
}
