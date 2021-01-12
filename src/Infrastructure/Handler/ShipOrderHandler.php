<?php

namespace App\Infrastructure\Handler;

use App\Domain\Ship\Service\ShipOrderService;
use App\Infrastructure\Converter\XmlToObjectConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ShipOrderHandler implements ProcessFilesHandlerInterface
{

    /**
     * @var ShipOrderService
     */
    private ShipOrderService $shipOrderService;

    /**
     * ShipOrderHandler constructor.
     * @param ShipOrderService $shipOrderService
     */
    public function __construct(ShipOrderService $shipOrderService)
    {
        $this->shipOrderService = $shipOrderService;
    }

    /**
     * @param UploadedFile $file
     */
    public function handle(UploadedFile $file): void
    {
        $xmlFile = simplexml_load_file($file->getRealPath());
        $shipOrder = (new XmlToObjectConverter($xmlFile))->toObject();

        $this->shipOrderService->saveShipOrder($shipOrder);
    }
}
