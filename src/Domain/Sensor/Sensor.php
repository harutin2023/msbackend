<?php

declare(strict_types=1);

namespace App\Domain\Sensor;

use JsonSerializable;
use Slim\Exception\HttpBadRequestException;

class Sensor implements JsonSerializable
{
    private const SENSOR_COUNT = 10000;

    private ?int $id;

    private float $temperature;

    private int $created;

    private string $face;

    public function __construct(?int $id, float $temperature, int $created, string $face)
    {
        if (!$this->checkSensorsCount()) {
            throw new \DomainException("The Sensors count overrated");
        }
        $this->id = $id;
        $this->temperature = $temperature;
        $this->created = $created;
        $this->face = $face;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getFace(): string
    {
        return $this->face;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'temperature' => $this->temperature,
            'face' => $this->face,
            'created' => $this->created,
        ];
    }

    /**
     * @return bool
     */
    public function checkSensorsCount(): bool
    {
        return true;
    }
}
