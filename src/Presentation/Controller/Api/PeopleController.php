<?php

namespace App\Presentation\Controller\Api;

use App\Infrastructure\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends AbstractController
{
    /**
     * @var PersonRepository
     */
    private PersonRepository $repository;

    /**
     * PeopleController constructor.
     * @param PersonRepository $repository
     */
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(
     *     "/api/person/{id}",
     *      name="api_get_person",
     *      methods={"GET"},
     *      requirements={"id"="\d+"}
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getPerson(int $id): JsonResponse
    {
        try {
            if (empty($id)) {
                throw new \InvalidArgumentException('ID not found.');
            }

            $person = $this->repository->find($id);

            return $this->json($person, Response::HTTP_ACCEPTED);
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

    /**
     * @Route(
     *     "/api/people",
     *      name="api_get_people",
     *      methods={"GET"}
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPeople(Request $request): JsonResponse
    {
        try {
            $people = $this->repository->findAll();

            return $this->json($people, Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return $this->json(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
