<?php

namespace App\Domain\Person\Service;

use App\Domain\Person\Entity\Person;
use App\Domain\Person\Entity\Phone;
use App\Domain\Exception\PersonAlreadyExistsException;
use App\Infrastructure\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;

class PersonService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var PersonRepository
     */
    private PersonRepository $repository;

    /**
     * PersonService constructor.
     * @param EntityManagerInterface $manager
     * @param PersonRepository $repository
     */
    public function __construct(
        EntityManagerInterface $manager,
        PersonRepository $repository
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @param object $xmlPeople
     */
    public function savePeople(object $xmlPeople): void
    {
        foreach ($xmlPeople->person as $person) {
            $personExists = $this->repository->find((int) $person->personid);

            if ($personExists) {
                throw new PersonAlreadyExistsException(
                    sprintf(
                        'You are sending XML with a person already registered with ID %d, please check your XML.',
                        $person->personid
                    )
                );
            }

            $newPerson = new Person();
            $newPerson->setId((int) $person->personid);
            $newPerson->setName($person->personname);

            $phones = is_array($person->phones->phone)
                ? $person->phones->phone
                : [$person->phones->phone]
            ;

            foreach ($phones as $phone) {
                $newPhone = new Phone();
                $newPhone->setNumber($phone);
                $newPhone->setPerson($newPerson);
                $newPerson->addPhone($newPhone);
            }

            $this->manager->persist($newPerson);
        }

        $this->manager->flush();
    }
}
