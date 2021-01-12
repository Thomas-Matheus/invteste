<?php

namespace App\Domain\Ship\Service;

use App\Domain\Ship\Entity\Item;
use App\Domain\Ship\Entity\ShipOrder;
use App\Domain\Ship\Entity\ShipTo;
use App\Domain\Exception\OrderAlreadyExistsException;
use App\Domain\Exception\PersonNotFoundException;
use App\Infrastructure\Repository\PersonRepository;
use App\Infrastructure\Repository\ShipOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShipOrderService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var PersonRepository
     */
    private PersonRepository $personRepository;

    /**
     * @var ShipOrderRepository
     */
    private ShipOrderRepository $shipOrderRepository;

    /**
     * ShipOrderService constructor.
     *
     * @param EntityManagerInterface $manager
     * @param PersonRepository $personRepository
     * @param ShipOrderRepository $shipOrderRepository
     */
    public function __construct(
        EntityManagerInterface $manager,
        PersonRepository $personRepository,
        ShipOrderRepository $shipOrderRepository
    ) {
        $this->manager = $manager;
        $this->personRepository = $personRepository;
        $this->shipOrderRepository = $shipOrderRepository;
    }

    /**
     * @param object $xmlOrders
     */
    public function saveShipOrder(object $xmlOrders): void
    {
        foreach ($xmlOrders->shiporder as $order) {
            $person = $this->personRepository->find((int) $order->orderperson);

            if (empty($person)) {
                throw new PersonNotFoundException(
                    sprintf(
                        'You are sending XML with an unregistered person with ID %d, please check your XML.',
                        $order->orderperson
                    )
                );
            }

            $orderExists = $this->shipOrderRepository->find((int) $order->orderid);

            if (!empty($orderExists)) {
                throw new OrderAlreadyExistsException(
                    sprintf(
                        'You are sending XML with an order already registered with ID %d, please check your XML.',
                        $order->orderid
                    )
                );
            }

            $shipTo = new ShipTo();
            $shipTo->setName($order->shipto->name);
            $shipTo->setAddress($order->shipto->address);
            $shipTo->setCity($order->shipto->city);
            $shipTo->setCountry($order->shipto->country);

            $shipOrder = new ShipOrder();
            $shipOrder->setId((int) $order->orderid);
            $shipOrder->setPersonOrder($person);
            $shipOrder->setShipTo($shipTo);

            $orderItems = is_array(current($order->items))
                ? current($order->items)
                : $order->items
            ;

            foreach ($orderItems as $itemXml) {
                $item = new Item();
                $item->setTitle($itemXml->title);
                $item->setNote($itemXml->note);
                $item->setQuantity($itemXml->quantity);
                $item->setPrice($itemXml->price);
                $item->setShipOrder($shipOrder);

                $shipOrder->addItem($item);
            }

            $this->manager->persist($shipOrder);
        }

        $this->manager->flush();
    }
}
