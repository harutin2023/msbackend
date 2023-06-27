<?php

declare(strict_types=1);

namespace App\Application\Actions\Sensor;

use App\Domain\DomainException\DomainException;
use Psr\Http\Message\ResponseInterface as Response;

class StoreSensorAction extends SensorAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        try {
            $sensorData = $this->getFormData();
            if ($this->sensorValidator->isValid($sensorData)) {
                $sensor = $this->sensorRepository->storeData($sensorData);
                $this->logger->info("Sensor was stored.");
            }
            return $this->respondWithData($sensor);
        } catch (DomainException $e) {
            $this->logger->info("Something went wrong");
        }
    }
}
