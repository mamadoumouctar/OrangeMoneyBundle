<?php

namespace Tm\OrangeMoneyBundle\Test\Http;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Tm\OrangeMoneyBundle\Http\Token;

class TokenTest extends TestCase
{
    public function testFetchValidToken()
    {
        $client = $this->getHttpClientInterface($this->getResponseInterface());
        $token = new Token($client, $this->getContainerBagInterface());
        $this->assertEquals('token', $token->getToken());
        $this->assertEquals('refresh', $token->getRefreshToken());
    }

    public function testFetchInValidToken()
    {
        $client = $this->getHttpClientInterface($this->getResponseInterface(false));
        $bags = $this->getContainerBagInterface();
        $this->expectException(HttpException::class);
        $token = new Token($client, $bags);
        $this->assertEquals('', $token->getToken());
        $this->assertEquals('', $token->getRefreshToken());
    }

    private function getResponseInterface(bool $valid = true): ResponseInterface
    {
        $validToken = '{"access_token":"token","token_type":"bearer","expires_in":299,"scope":"apimanagement email profile","refresh_token":"refresh","refresh_expires_in":1800}';
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->getMock()
        ;
        if($valid){
            $response->expects($this->once())->method('getContent')->willReturn($validToken);
            $response->expects($this->once())->method('getStatusCode')->willReturn(200);
        }else{
            $response->expects($this->never())->method('getContent');
            $response->expects($this->once())->method('getStatusCode')->willReturn(400);
        }
        return $response;
    }

    private function getHttpClientInterface(ResponseInterface $response): HttpClientInterface
    {
        $client = $this->getMockBuilder(HttpClientInterface::class)
            ->getMock()
        ;
        $client->expects($this->once())->method('request')->willReturn($response);
        return $client;
    }

    private function getContainerBagInterface(): ContainerBagInterface
    {
        $bag = $this->getMockBuilder(ContainerBagInterface::class)
            ->getMock()
        ;
        //$bag->expects($this->once());
        return $bag;
    }

}