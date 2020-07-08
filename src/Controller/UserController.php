<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\Voter\AdminVoter;
use App\Service\PersisterService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     *
     * @param UserRepository $userRepository
     *
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/public/new", name="user_new", methods={"GET","POST"})
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $encoder
     * @param UserRepository               $userRepository
     *
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository, PersisterService $persisterService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [UserType::REGISTER_OPTION => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appHasUser = $userRepository->findBy([], [], 1);
            if (!$appHasUser) {
                $user->setRoles([User::ROLE_ADMIN, User::ROLE_USER]);
            }
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $persisterService->save($user);

            $this->addFlash('success', 'user_added_successfully');

            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     *
     * @param User $user
     *
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/public/{id}/edit", name="user_edit", methods={"GET","POST"})
     *
     * @param Request                      $request
     * @param User                         $user
     * @param UserPasswordEncoderInterface $encoder
     * @param Security                     $security
     *
     * @return Response
     */
    public function edit(Request $request, User $user, UserService $userService, PersisterService $persisterService): Response
    {
        $editedUser = new User();
        $editedUser->setNick($user->getNick());
        $editedUser->setRoles($user->getRoles());

        $form = $this->createForm(
            UserType::class,
            $editedUser,
            [UserType::CONFIRM_PASSWORD_OPTION => true]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$userService->isPasswordConfirmed($user, $editedUser->getConfirmPassword())) {
                $this->addFlash('danger', 'invalid_confirmed_password');

                return $this->redirectToRoute('medicine_index');
            }

            if (!$this->isGranted(AdminVoter::CHANGE_ROLE, $editedUser)) {
                $this->addFlash('danger', 'you_are_not_allowed_to_change_role');

                return $this->redirectToRoute('medicine_index');
            }

            $userService->appendChanges($user, $editedUser);
            $persisterService->save($user);

            $this->addFlash('success', 'user_edited_successfully');

            return $this->redirectToRoute('medicine_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     */
    public function delete(Request $request, User $user, PersisterService $persisterService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $persisterService->remove($user);
            $this->addFlash('danger', 'user_deleted');
        }

        return $this->redirectToRoute('user_index');
    }
}
