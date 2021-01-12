<?php

namespace App\Domain\Person\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Person
{

    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var Collection|Phone[]
     */
    private Collection $phones;

    /**
     * People constructor.
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    /**
     * @param Phone $phone
     * @return $this
     */
    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setPerson($this);
        }

        return $this;
    }

    /**
     * @param Phone $phone
     * @return $this
     */
    public function removePhone(Phone $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            if ($phone->getPerson() === $this) {
                $phone->setPerson(null);
            }
        }

        return $this;
    }
}
