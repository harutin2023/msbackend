<?php

declare(strict_types=1);

namespace App\Application\Actions\Sensor;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteSensorAction extends SensorAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $sensorId = (int) $this->resolveArg('id');
        $this->sensorRepository->delete($sensorId);

        $this->logger->info("Sensor of id `${sensorId}` was deleted.");

        return $this->respondWithData([]);
    }
}
