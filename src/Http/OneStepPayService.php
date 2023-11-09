<?php

namespace Tm\OrangeMoneyBundle\Http;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Tm\OrangeMoneyBundle\Entity\Merchant;
use Tm\OrangeMoneyBundle\Entity\Transaction;

class OneStepPayService
{

    public function __construct(
        private readonly Token $token,
        //private readonly EventDispatcherInterface $dispatcher
    ){}

    public function pay(Transaction $transaction, Merchant $partner): void
    {
        $this->token->fetchOneStepPay($transaction, $partner);

        //$this->dispatcher->dispatch();
    }
}