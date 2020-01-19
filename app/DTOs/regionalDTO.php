<?php

namespace App\DTOs;

class RegionalDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var SubstationDTO[]
     */
    private $substations;

    /**
     * RegionalDTO constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->substations = [];
    }

    /**
     * @param SubstationDTO $substation
     * @return $this
     */
    public function addSubstation(SubstationDTO $substation): self
    {
        $this->substations[] = $substation;

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
     * @return SubstationDTO[]
     */
    public function getSubstations(): array
    {
        return $this->substations;
    }
}
