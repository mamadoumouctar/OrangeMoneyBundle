<?php

namespace Tm\OrangeMoneyBundle\Http\Api\SandBox;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tm\OrangeMoneyBundle\Entity\Custumer;
use Tm\OrangeMoneyBundle\Http\Api\Service;

class GetOTPService extends Service
{

    public function __invoke(Custumer $custumer): object
    {
        try {
            $response = $this->client->request('POST', $this->base . '/api/eWallet/v1/payments/otp', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '. $this->token->getToken()
                ],
                'body' => json_encode([
                    'customer' => [
                        'idType' => $custumer->getType()->value,
                        'id' => $custumer->getId(),
                    ]
                ])
            ]);
            if($response->getStatusCode() == 200){
                //TODO: Make it return the right object
                return json_decode($response->getContent());
            }else{
                throw new HttpException(400, "Orange Money Error. Invalid Crédentials");
            }
        }catch (\Exception | \Throwable $e){
            if ($e instanceof HttpException) throw $e;
        }
    }
}
