<?php

namespace App\Presentation\Controller\Api;

use App\Infrastructure\Repository\ShipOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShipOrderController extends AbstractController
{

    /**
     * @var ShipOrderRepository
     */
    private ShipOrderRepository $repository;

    /**
     * ShipOrderController constructor.
     * @param ShipOrderRepository $repository
     */
    public function __construct(ShipOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(
     *     "/api/order/{id}",
     *      name="api_get_order",
     *      methods={"GET"},
     *      requirements={"id"="\d+"}
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getOrder(int $id): JsonResponse
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
     *     "/api/orders",
     *      name="api_get_orders",
     *      methods={"GET"},
     * )
     *
     * @return JsonResponse
     */
    public function getOrders(): JsonResponse
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
