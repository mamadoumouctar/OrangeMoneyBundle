<?php

namespace Tm\OrangeMoneyBundle\Http;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Tm\OrangeMoneyBundle\Entity\Merchant;
use Tm\OrangeMoneyBundle\Entity\Transaction;

class Token
{
    private string $token = '';
    private string $refreshToken = '';

    public function __construct(
        private HttpClientInterface $client,
        private ContainerBagInterface $bag
    ){
        $this->fetchToken();
    }

    public function fetchToken(): void
    {
        try {
            $response = $this->client->request('POST',
                $this->bag->get('mamadou.orange_money.base').'/oauth/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'body' => [
                    'grant_type' => 'client_credentials',
                    'client_secret' => $this->bag->get('mamadou.orange_money.client_secret'),
                    'client_id' => $this->bag->get('mamadou.orange_money.client_id')
                ]
            ]);
            if($response->getStatusCode() === 200){
                $data = json_decode($response->getContent(), true);
                $this->token = $data['access_token'];
                $this->refreshToken = $data['refresh_token'];
            }else{
                throw new HttpException(400, "Orange Money Error. Invalid Crédentials");
            }
        } catch (\Exception | \Throwable $e) {
            if($e instanceof HttpException) throw $e;
        }
    }

    public function fetchOneStepPay(Transaction $transaction, Merchant $partner): void
    {
        try {
            $response = $this->client->request('POST', $this->bag->get('mamadou.orange_money.base') . '/api/eWallet/v1/payments/onestep', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '. $this->token
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
            }
        }catch (\Exception | \Throwable $e){
            if ($e instanceof HttpException) throw $e;
        }
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }
}
