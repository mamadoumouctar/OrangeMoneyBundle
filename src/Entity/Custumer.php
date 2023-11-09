<?php

namespace Tm\OrangeMoneyBundle\Entity;

class Custumer
{
    public function __construct(
        private string $id = '',
        private string $otp = '',
        private IdEnumType $type = IdEnumType::MSISDN
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Custumer
    {
        $this->id = $id;
        return $this;
    }

    public function getOtp(): string
    {
        return $this->otp;
    }

    public function setOtp(string $otp): Custumer
    {
        $this->otp = $otp;
        return $this;
    }

    public function getType(): IdEnumType
    {
        return $this->type;
    }

    public function setType(IdEnumType $type): Custumer
    {
        $this->type = $type;
        return $this;
    }
}
