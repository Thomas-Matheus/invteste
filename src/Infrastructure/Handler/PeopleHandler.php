<?php

namespace App\Infrastructure\Handler;

use App\Domain\Person\Service\PersonService;
use App\Infrastructure\Converter\XmlToObjectConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PeopleHandler implements ProcessFilesHandlerInterface
{

    /**
     * @var PersonService
     */
    private PersonService $personService;

    /**
     * PeopleHandler constructor.
     * @param PersonService $personService
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    /**
     * @param UploadedFile $file
     */
    public function handle(UploadedFile $file): void
    {
        $xmlFile = simplexml_load_file($file->getRealPath());
        $people = (new XmlToObjectConverter($xmlFile))->toObject();

        $this->personService->savePeople($people);
    }
}
