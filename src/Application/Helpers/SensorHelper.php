<?php

namespace App\Application\Helpers;

use App\Domain\Sensor\Sensor;

trait SensorHelper
{
    private string $sensorsStoragePath = __DIR__ . '/../../../public/storage/';

    public function getAllSensors()
    {
        $sensors = [];
        try {
            if ($handle = opendir($this->sensorsStoragePath)) {

                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $sensors[] = json_decode(file_get_contents($this->sensorsStoragePath . $entry));
                    }
                }
                closedir($handle);
            }
        } catch (\Exception $e) {
        }

        return $sensors;
    }

    /**
     * @param int $id
     * @return Sensor
     */
    public function getSensorById(int $id): Sensor
    {
        $sensor = null;
        try {
            $sensorData = json_decode(file_get_contents($this->sensorsStoragePath . $id . '.json'));
            $sensor = new Sensor($sensorData->id, $sensorData->temperature, $sensorData->created, $sensorData->face);
        } catch (\Exception $e) {
        }

        return $sensor;
    }

    /**
     * @return int
     */
    public function getLastSensorId(): int
    {
        $sensors = $this->getAllSensors();

        if (count($sensors) == 0) {
            return 0;
        }
        usort($sensors, fn($a, $b) => $a->id <=> $b->id);

        $lastSensor = end($sensors);

        return $lastSensor->id;
    }

    /**
     * @param array $sensorData
     * @return mixed
     */
    public function storeSensor(array $sensorData): mixed
    {
        $id = $this->getLastSensorId() + 1;
        $sensorData['id'] =  $id;
        if (file_put_contents($this->sensorsStoragePath . $id . '.json', json_encode($sensorData))) {
            return $id;
        }
        return false;
    }

    /**
     * @param array $sensorData
     * @param Sensor $sensor
     * @return mixed
     */
    public function editSensorData(array $sensorData, Sensor $sensor): mixed
    {
        try {

            $editSensorData['id'] = $sensor->getId();
            $editSensorData['temperature'] = $sensorData['temperature'];
            $editSensorData['face'] = $sensorData['face'];
            $editSensorData['created'] = $sensor->getCreated();

            if (file_put_contents($this->sensorsStoragePath . $sensor->getId() . '.json', json_encode($editSensorData))) {
                return $this->getSensorById($sensor->getId());
            }
        } catch (\Exception $e){}

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function removeSensor(int $id): bool
    {
        $sensorPath = $this->sensorsStoragePath . $id . '.json';
        return unlink($sensorPath);
    }
}
