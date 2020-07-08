<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class UserService
{
    private $security;

    private $encoder;

    public function __construct(Security $security, UserPasswordEncoderInterface $encoderInterface)
    {
        $this->security = $security;
        $this->encoder = $encoderInterface;
    }

    public function isPasswordConfirmed(User $user, ?string $passwordConfirm): bool
    {
        if (null === $passwordConfirm) {
            return false;
        }

        $user->setConfirmPassword($passwordConfirm);

        return $this->encoder->isPasswordValid($this->security->getUser(), $user->getConfirmPassword());
    }

    public function appendChanges(User $user, User $editedUser): User
    {
        $password = $editedUser->getPassword();
        if ($password) {
            $user->setPassword($password);
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        }
        $user->setNick($editedUser->getNick());
        $user->setRoles($editedUser->getRoles());

        return $user;
    }
}
