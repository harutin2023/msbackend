<?php

declare(strict_types=1);

namespace App\Application\Actions\Sensor;

use Psr\Http\Message\ResponseInterface as Response;

class EditSensorAction extends SensorAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $sensorData = (array) $this->getFormData();
        $sensorId = (int) $this->resolveArg('id');
        $sensor = $this->sensorRepository->updateData($sensorData, $sensorId);

        $this->logger->info("Sensor was stored.");

        return $this->respondWithData($sensor);
    }
}
