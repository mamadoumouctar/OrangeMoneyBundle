<?php

namespace Tm\OrangeMoneyBundle\Http\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Tm\OrangeMoneyBundle\Http\Token;

abstract class Service
{
    public function __construct(
        protected readonly Token $token,
        protected HttpClientInterface $client,
        protected readonly string $base
    ){}
}
