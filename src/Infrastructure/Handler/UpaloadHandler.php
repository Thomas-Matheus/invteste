<?php

namespace App\Infrastructure\Handler;

use App\Domain\Exception\EmptyFileException;

class UpaloadHandler implements UploadedHandlerInterface
{

    /**
     * @var PeopleHandler
     */
    private PeopleHandler $peopleHandler;

    /**
     * @var ShipOrderHandler
     */
    private ShipOrderHandler $shipOrderHandler;

    /**
     * UpaloadHandler constructor.
     *
     * @param PeopleHandler $peopleHandler
     * @param ShipOrderHandler $shipOrderHandler
     */
    public function __construct(PeopleHandler $peopleHandler, ShipOrderHandler $shipOrderHandler)
    {
        $this->peopleHandler = $peopleHandler;
        $this->shipOrderHandler = $shipOrderHandler;
    }

    /**
     * @param array $files
     */
    public function handle(array $files): void
    {
        if (empty($files['shipOrders']) || empty($files['people'])) {
            throw new EmptyFileException('It is necessary to send files for processing.');
        }

        $this->peopleHandler->handle($files['people']);
        $this->shipOrderHandler->handle($files['shipOrders']);
    }
}
