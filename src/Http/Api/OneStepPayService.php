<?php

namespace Tm\OrangeMoneyBundle\Http\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tm\OrangeMoneyBundle\Entity\Merchant;
use Tm\OrangeMoneyBundle\Entity\Transaction;

class OneStepPayService extends Service
{
    public function __invoke(Transaction $transaction, Merchant $partner): mixed
    {
        try {
            $response = $this->client->request('POST', $this->base . '/api/eWallet/v1/payments/onestep', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '. $this->token->getToken()
                ],
                'body' => json_encode([
                    'customer' => [
                        'idType' => $transaction->getClient()->getType()->value,
                        'id' => $transaction->getClient()->getId(),
                        'otp' => $transaction->getClient()->getOtp()
                    ],
                    'partner' => [
                        'type' => $partner->getType()->value,
                        'id' => $partner->getId()
                    ],
                    'amount' => [
                        'value' => $transaction->getAmount(),
                        'unit' => $transaction->getUnitAmount()->value
                    ],
                    //'metadata' => json_encode($transaction)
                ])
            ]);
            if($response->getStatusCode() == 200){
                dump($response->getContent());
                return $transaction;
            }else{
                throw new HttpException(400, "Orange Money Error. Invalid Crédentials");
            }
        }catch (\Exception | \Throwable $e){
            if ($e instanceof HttpException) throw $e;
        }
    }
}
