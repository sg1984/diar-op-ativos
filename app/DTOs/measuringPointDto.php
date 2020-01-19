<?php

namespace App\DTOs;

class MeasuringPointDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $has_abnormality;

    /**
     * @var string
     */
    private $system;

    public function __construct(string $name, bool $has_abnormality, string $system)
    {
        $this->name = $name;
        $this->has_abnormality = $has_abnormality;
        $this->system = $system;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasAbnormality(): bool
    {
        return $this->has_abnormality;
    }

    public function getSystem(): string
    {
        return $this->system;
    }
}
