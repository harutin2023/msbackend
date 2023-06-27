<?php

declare(strict_types=1);

namespace App\Application\Actions\Sensor;

use App\Application\Actions\Action;
use App\Application\Validator\SensorValidator;
use App\Domain\Sensor\SensorRepository;
use Psr\Log\LoggerInterface;

abstract class SensorAction extends Action
{
    protected SensorRepository $sensorRepository;
    protected SensorValidator $sensorValidator;

    public function __construct(LoggerInterface $logger, SensorRepository $sensorRepository, SensorValidator $sensorValidator)
    {
        parent::__construct($logger);
        $this->sensorRepository = $sensorRepository;
        $this->sensorValidator = $sensorValidator;
    }
}
