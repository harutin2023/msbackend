<?php

declare(strict_types=1);

namespace App\Domain\Sensor;

interface SensorRepository
{
    /**
     * @return Sensor[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Sensor
     * @throws SensorNotFoundException
     */
    public function findSensorOfId(int $id): Sensor;

    /**
     * @param array $data
     * @return Sensor
     * @throws SensorNotFoundException
     */
    public function storeData(array $data): Sensor;

    /**
     * @param array $data
     * @param int $id
     * @return Sensor
     */
    public function updateData(array $data, int $id): Sensor;

    /**
     * @return int
     */
    public function getCount(): int;
}
