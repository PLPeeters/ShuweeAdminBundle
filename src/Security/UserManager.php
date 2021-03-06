<?php

namespace Wanjee\Shuwee\AdminBundle\Security;

use Doctrine\ORM\EntityManager;
use Wanjee\Shuwee\AdminBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UserManager
 * @package Wanjee\Shuwee\AdminBundle\Security
 */
class UserManager
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;


    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EncoderFactoryInterface $encoderFactory, EntityManager $em)
    {
        $this->encoderFactory = $encoderFactory;
        $this->em = $em;
    }

    /**
     * @param string $userName
     * @param string $email
     * @param string $password
     * @param array $roles
     * @return \Wanjee\Shuwee\AdminBundle\Entity\User
     */
    public function createUser($userName, $email, $password, array $roles)
    {
        $user = new User();

        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        $user
            ->setUsername($userName)
            ->setEmail($email)
            ->setPassword($encodedPassword)
            ->setRoles($roles);

        $this->em->persist($user);
        $this->em->flush($user);
    }
}