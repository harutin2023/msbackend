<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Sensor;

use App\Domain\DomainException\DomainException;
use App\Domain\Sensor\Sensor;
use App\Domain\Sensor\SensorNotFoundException;
use App\Domain\Sensor\SensorRepository;
use App\Application\Helpers\SensorHelper;

class InMemorySensorRepository implements SensorRepository
{
    use SensorHelper;

    /**
     * @var Sensor[]
     */
    private static array $sensors = [];

    /**
     * @param Sensor[]|null $sensors
     */
    public function __construct(array $sensors = null)
    {
        $this->getSensors($sensors);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values(self::$sensors);
    }

    /**
     * {@inheritdoc}
     */
    public function findSensorOfId(int $id): Sensor
    {
        if (!isset(self::$sensors[$id])) {
            throw new SensorNotFoundException();
        }

        return self::$sensors[$id];
    }

    /**
     * @param array $data
     * @return Sensor
     */
    public function storeData(array $data): Sensor
    {
        $id = $this->storeSensor($data);
        $sensorObj = new Sensor($id, $data['temperature'], $data['created'], $data['face']);
        self::$sensors[$id] = $sensorObj;
        return self::$sensors[$id];
    }

    /**
     * @param array $data
     * @param int $id
     * @return Sensor
     * @throws SensorNotFoundException
     */
    public function updateData(array $data, int $id): Sensor
    {
        if (!isset(self::$sensors[$id])) {
            throw new SensorNotFoundException();
        }

        $sensor = self::$sensors[$id];

        $this->editSensorData($data, $sensor);

        return self::$sensors[$id];
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->removeSensor($id);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count(self::$sensors);
    }

    /**
     * @param array|null $sensors
     * @return void
     */
    public function getSensors(array|null $sensors)
    {
        $sensorsData = $this->getAllSensors();

        if (empty($sensorsData) && is_array($sensors)) {
            $sensorsData[] = $sensors;
        }

        foreach ($sensorsData as $sensor) {
            self::$sensors[$sensor->id] = new Sensor($sensor->id, $sensor->temperature, $sensor->created, $sensor->face);
        }
    }
}
