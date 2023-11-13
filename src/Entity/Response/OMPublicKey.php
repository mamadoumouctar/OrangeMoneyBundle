<?php

namespace Tm\OrangeMoneyBundle\Entity\Response;

readonly class OMPublicKey implements \JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return [
            'keyId' => $this->keyId,
            'keyType' => $this->keyType,
            'keySize' => $this->keySize,
            'key' => $this->key
        ];
    }
}
