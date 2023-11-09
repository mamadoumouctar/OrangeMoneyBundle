<?php
namespace Tm\OrangeMoneyBundle\Test\Http;

use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Tm\OrangeMoneyBundle\Entity\Custumer;
use Tm\OrangeMoneyBundle\Entity\Merchant;
use Tm\OrangeMoneyBundle\Entity\Transaction;
use Tm\OrangeMoneyBundle\Http\OneStepPayService;
use Tm\OrangeMoneyBundle\OrangeMoneyBundle;

class OneStepPayTest extends KernelTestCase
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
        $kernel->addTestConfig(__DIR__. '/config.yaml');
        $kernel->handleOptions($options);
        return $kernel;
    }

    public function testWithWringOtp()
    {
        /** @var OneStepPayService $service */
        $this->expectException(HttpException::class);
        $service = $this->getContainer()->get(OneStepPayService::class);
        $transaction = new Transaction(new Custumer('786175701', '1111'), 7);
        $service->pay($transaction, new Merchant('485422'));
    }
}
