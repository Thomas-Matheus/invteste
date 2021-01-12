<?php

namespace App\Presentation\Controller\Api;

use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthenticationController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * AuthenticationController constructor.
     *
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator
    ) {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->validator = $validator;
    }

    /**
     * @Route("/resgister", name="register", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse {
        try {
            $userData = json_decode($request->getContent());

            $user = new User();
            $user->setUsername($userData->username);
            $user->setPassword($this->encoder->encodePassword($user, $userData->password));

            $errors = $this->validator->validate($user);

            if (count($errors) > 0) {
                throw new \InvalidArgumentException(
                    $errors
                );
            }

            $this->manager->persist($user);
            $this->manager->flush();

            return $this->json([
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'An unexpected error has occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
