<?php

namespace Tm\OrangeMoneyBundle\Test\Http\Api;

use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Tm\OrangeMoneyBundle\Entity\Response\OMPublicKey;
use Tm\OrangeMoneyBundle\Http\Api\PublicKeyService;
use Tm\OrangeMoneyBundle\Http\Token;
use Tm\OrangeMoneyBundle\OrangeMoneyBundle;

class OMPublicKeyTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(OrangeMoneyBundle::class);
        $kernel->addTestConfig(dirname(__DIR__). '/config.yaml');
        $kernel->handleOptions($options);
        return $kernel;
    }

    public function testFetchPublicKey()
    {
        $service = $this->getContainer()->get(PublicKeyService::class);
        /** @var OMPublicKey $response */
        $response = $service();
        $this->assertNotEmpty($response->getKey());
    }

    public function testFetchPublicKeyWithInvalidParamsBaseName()
    {
        $container = $this->getContainer();
        $token = $container->get(Token::class);
        $httpClient = $container->get(HttpClientInterface::class);
        $service = new PublicKeyService($token, $httpClient, 'kdfjkd');
        $this->expectException(\Exception::class);
        /** @var OMPublicKey $response */
        $response = $service();
    }
}
