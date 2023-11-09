<?php

namespace Tm\OrangeMoneyBundle\Entity;

class Merchant
{
    public function __construct(
        private string $id,
        private IdEnumType $type = IdEnumType::CODE
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Merchant
    {
        $this->id = $id;
        return $this;
    }

    public function getType(): IdEnumType
    {
        return $this->type;
    }

    public function setType(IdEnumType $type): Merchant
    {
        $this->type = $type;
        return $this;
    }
}