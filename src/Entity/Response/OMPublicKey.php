<?php

namespace Tm\OrangeMoneyBundle\Entity\Response;

readonly class OMPublicKey
{
    public function __construct(
        private string $keyId,
        private string $keyType,
        private string $keySize,
        private string $key
    ){}

    public function getKeyId(): string
    {
        return $this->keyId;
    }

    public function getKeyType(): string
    {
        return $this->keyType;
    }

    public function getKeySize(): string
    {
        return $this->keySize;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
