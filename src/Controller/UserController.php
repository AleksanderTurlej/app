<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
//        $granted = $this->isGranted('ROLE_ADMIN');
//        if (!$granted) {
//            return $this->render('utilts/example.html.twig');
//        }

        return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/public/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [UserType::REGISTER_OPTION => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appHasUser = $userRepository->findBy([], [], 1);
            if(!$appHasUser){
                $user-> setRoles([User::ROLE_ADMIN, User::ROLE_USER]);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder, Security $security): Response
    {
        $editedUser = new User();
        $editedUser->setNick($user->getNick());


        $form = $this->createForm(UserType::class, $editedUser,
            [UserType::CONFIRM_PASSWORD_OPTION => true]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setConfirmPassword($editedUser->getConfirmPassword());
            $passwordConfirmed = $encoder->isPasswordValid($security->getUser(), $user->getConfirmPassword());

            if(!$passwordConfirmed && !$this->isGranted(User::ROLE_ADMIN)){
                return $this->redirectToRoute('user_index');
            }

            $menager = $this->getDoctrine()->getManager();
            $user->setPassword($editedUser->getPassword());
            $user->setNick($editedUser->getNick());
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $menager->persist($user);
            $menager->flush();

            $this->addFlash('success', 'password_changed');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('danger', 'user_deleted');

        }

        return $this->redirectToRoute('user_index');
    }
}
