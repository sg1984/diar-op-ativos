<?php

namespace App\DTOs;

class RegionalCollectionDTO
{
    /**
     * @var RegionalDTO[]
     */
    private $regionals;

    /**
     * RegionalCollectionDTO constructor.
     */
    public function __construct()
    {
        $this->regionals = [];
    }

    /**
     * @param RegionalDTO $regionalDTO
     * @return $this
     */
    public function addRegional(RegionalDTO $regionalDTO): self
    {
        $this->regionals[] = $regionalDTO;

        return $this;
    }

    /**
     * @return RegionalDTO[]
     */
    public function getRegionals(): array
    {
        return $this->regionals;
    }
}
