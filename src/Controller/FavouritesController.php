<?php

namespace App\Controller;

use App\Entity\Favourites;
use App\Entity\Medicine;
use App\Entity\User;
use App\Form\FavouritesType;
use App\Repository\FavouritesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/favourites")
 */
class FavouritesController extends AbstractController
{
    /**
     * @Route("/", name="favourites_index", methods={"GET"})
     *
     * @param FavouritesRepository $favouritesRepository
     * @param Security             $security
     *
     * @return Response
     */
    public function index(FavouritesRepository $favouritesRepository, Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('favourites/index.html.twig', [
            'favourites' => $favouritesRepository->findBy(['user' => $user]),
        ]);
    }

    /**
     * @Route("/new/{id}", name="favourites_new", methods={"GET","POST"})
     *
     * @param Request              $request
     * @param Medicine             $medicine
     * @param Security             $security
     * @param FavouritesRepository $repository
     *
     * @return Response
     *
     * @noinspection PhpParamsInspection
     */
    public function new(Request $request, Medicine $medicine, Security $security, FavouritesRepository $repository): Response
    {
//      $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $security->getUser();
        if (!$this->isLoggedUser($user)) {
            $this->addFlash('danger', 'log_in_to_add_favourite');

            return $this->redirect($this->generateUrl($request->headers->get('referer')));
        }

        $favourite = $repository->findOneBy(['user' => $user, 'medicine' => $medicine]) ?? new Favourites();
        $form = $this->createForm(FavouritesType::class, $favourite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isLoggedUser($user)) {
            $favourite->setUser($user);
            $favourite->setMedicine($medicine);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favourite);
            $entityManager->flush();
            $this->addFlash('success', 'added_as_favourite');

            return $this->redirectToRoute('favourites_index');
        }

        return $this->render('favourites/new.html.twig', [
            'favourite' => $favourite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favourites_show", methods={"GET"})
     *
     * @param Favourites $favourite
     *
     * @return Response
     */
    public function show(Favourites $favourite): Response
    {
        return $this->render('favourites/show.html.twig', [
            'favourite' => $favourite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="favourites_edit", methods={"GET","POST"})
     *
     * @param Request    $request
     * @param Favourites $favourite
     *
     * @return Response
     */
    public function edit(Request $request, Favourites $favourite): Response
    {
        $form = $this->createForm(FavouritesType::class, $favourite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favourites_index');
        }

        return $this->render('favourites/edit.html.twig', [
            'favourite' => $favourite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favourites_delete", methods={"DELETE"})
     *
     * @param Request    $request
     * @param Favourites $favourite
     *
     * @return Response
     */
    public function delete(Request $request, Favourites $favourite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favourite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favourite);
            $entityManager->flush();
            $this->addFlash('danger', 'removed_from_favourites');
        }

        return $this->redirectToRoute('favourites_index');
    }

    private function isLoggedUser(?UserInterface $user): bool
    {
        return $user instanceof User;
    }
}
