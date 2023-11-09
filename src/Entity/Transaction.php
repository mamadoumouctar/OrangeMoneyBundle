<?php

namespace Tm\OrangeMoneyBundle\Entity;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class Transaction implements \JsonSerializable
{
    private string $id = '';

    public function __construct(
        private Custumer $client,
        private float $amount = 0,
        private UnitAmount $unitAmount = UnitAmount::XOF
    ){}

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Transaction
    {
        $this->id = $id;

        return $this;
    }

    public function getClient(): Custumer
    {
        return $this->client;
    }

    public function setClient(Custumer $client): Transaction
    {
        $this->client = $client;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    public function getUnitAmount(): UnitAmount
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(UnitAmount $unitAmount): Transaction
    {
        $this->unitAmount = $unitAmount;
        return $this;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'amountUnit' => $this->getUnitAmount(),
            'client' => [
                'id' => $this->getClient()->getId()
            ]
        ];
    }

    /** @phpstan-ignore-next-line */
    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this
            ->setAmount($data['amount'])
            ->setUnitAmount(UnitAmount::from($data['amountUnit']))
            ->setClient((new Custumer())->setId($data['client']['id']));
    }

    public function jsonSerialize(): mixed
    {
        return $this->__serialize();
    }

    public static function jsonToTransaction(string $json): self
    {
        $json = json_decode($json, true);
        $transaction = new self(new Custumer());
        $transaction->__unserialize($json);
        return $transaction;
    }
}
