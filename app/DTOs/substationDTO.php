<?php

namespace App\DTOs;

class SubstationDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var MeasuringPointDTO[]
     */
    private $measuringPoints;

    /**
     * SubstationDTO constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->measuringPoints = [];
    }

    /**
     * @param MeasuringPointDTO $measuringPoint
     * @return $this
     */
    public function addMeasuringPoint(MeasuringPointDTO $measuringPoint): self
    {
        $this->measuringPoints[] = $measuringPoint;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return MeasuringPointDTO[]
     */
    public function getMeasuringPoints(): array
    {
        return $this->measuringPoints;
    }
}
