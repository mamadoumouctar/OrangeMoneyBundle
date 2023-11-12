<?php

namespace Tm\OrangeMoneyBundle\Http\Api;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Tm\OrangeMoneyBundle\Entity\Response\OMPublicKey;

class PublicKeyService extends Service
{
    public function __invoke(): OMPublicKey
    {
        try {
            $response = $this->client->request('GET', $this->base . '/api/account/v1/publicKeys', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->token->getToken()
                ]
            ]);
            if($response->getStatusCode() == Response::HTTP_OK){
                $content = json_decode($response->getContent(), true);
                return new OMPublicKey(
                    $content['keyId'],
                    $content['keyType'],
                    $content['keySize'],
                    $content['key'],
                );
            }
        }catch (TransportExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|ClientExceptionInterface $e) {
            // TODO: Ajout du système d'erreur de Orange (Renvoyer un objet erreur)
            throw $e;
        }
    }
}
