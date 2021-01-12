<?php

namespace App\Domain\Person\Entity;

class Phone
{

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $number;

    /**
     * @var Person|null
     */
    private ?Person $person;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person|null $person
     */
    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }
}
