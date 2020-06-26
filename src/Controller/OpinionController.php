<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Entity\Opinion;
use App\Entity\User;
use App\Form\OpinionType;
use App\Repository\OpinionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/opinion")
 */
class OpinionController extends AbstractController
{
    /**
     * @Route("/", name="opinion_index", methods={"GET"})
     *
     * @param OpinionRepository $opinionRepository
     *
     * @return Response
     */
    public function index(OpinionRepository $opinionRepository): Response
    {
        return $this->render('opinion/index.html.twig', [
            'opinions' => $opinionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="opinion_new", methods={"GET","POST"})
     *
     * @param Request           $request
     * @param Medicine          $medicine
     * @param Security          $security
     * @param OpinionRepository $opinionRepository
     *
     * @return Response
     */
    public function new(Request $request, Medicine $medicine, Security $security, OpinionRepository $opinionRepository): Response
    {
        $user = $security->getUser();
        if (!$user instanceof User) {
            $this->addFlash('danger', 'log_in_to_add_comment');
        }
        $this->denyAccessUnlessGranted(User::ROLE_USER);

        $opinion = $opinionRepository->findOneBy(['userId' => $user->getId(), 'medicineId' => $medicine->getId()]) ?? new Opinion();
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $user instanceof User) {
            $opinion->setMedicine($medicine);
            $opinion->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($opinion);
            $entityManager->flush();
            $this->addFlash('success', 'comment_added');

            return $this->redirectToRoute('opinion_index');
        }

        return $this->render('opinion/new.html.twig', [
            'opinion' => $opinion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="opinion_show", methods={"GET"})
     *
     * @param Opinion $opinion
     *
     * @return Response
     */
    public function show(Opinion $opinion): Response
    {
        return $this->render('opinion/show.html.twig', [
            'opinion' => $opinion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="opinion_edit", methods={"GET","POST"})
     *
     * @param Request $request
     * @param Opinion $opinion
     *
     * @return Response
     */
    public function edit(Request $request, Opinion $opinion): Response
    {
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'comment_successfully_edited');

            return $this->redirectToRoute('opinion_index');
        }

        return $this->render('opinion/edit.html.twig', [
            'opinion' => $opinion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="opinion_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Opinion $opinion
     *
     * @return Response
     */
    public function delete(Request $request, Opinion $opinion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opinion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($opinion);
            $entityManager->flush();
            $this->addFlash('danger', 'comment_deleted');
        }

        return $this->redirectToRoute('opinion_index');
    }
}
