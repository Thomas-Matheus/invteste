<?php

namespace App\Domain\Ship\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ShipOrder
{

    /**
     * @var int
     */
    private int $id;

    /**
     * @var Person
     */
    private Person $personOrder;

    /**
     * @var ShipTo
     */
    private ShipTo $shipTo;

    /**
     * @var Collection|Item[]
     */
    private Collection $items;

    /**
     * ShipOrder constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Person
     */
    public function getPersonOrder(): Person
    {
        return $this->personOrder;
    }

    /**
     * @param Person $personOrder
     */
    public function setPersonOrder(Person $personOrder): void
    {
        $this->personOrder = $personOrder;
    }

    /**
     * @return ShipTo
     */
    public function getShipTo(): ShipTo
    {
        return $this->shipTo;
    }

    /**
     * @param ShipTo $shipTo
     */
    public function setShipTo(ShipTo $shipTo): void
    {
        $this->shipTo = $shipTo;
    }

    /**
     * @return Item[]|Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setShipOrder($this);
        }

        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getShipOrder() === $this) {
                $item->setShipOrder(null);
            }
        }

        return $this;
    }
}
