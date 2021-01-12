<?php

namespace App\Domain\User\Service;

use App\Infrastructure\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

class UserService
{

    /**
     * @var ServiceEntityRepositoryInterface
     */
    private ServiceEntityRepositoryInterface $repository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }
}
