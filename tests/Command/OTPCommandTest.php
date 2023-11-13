<?php
namespace Tm\OrangeMoneyBundle\Test\Command;

use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Tm\OrangeMoneyBundle\Command\OTPCommand;
use Tm\OrangeMoneyBundle\OrangeMoneyBundle;

class OTPCommandTest extends KernelTestCase
{
    private $application = null;
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(OrangeMoneyBundle::class);
        $kernel->addTestConfig(__DIR__. '../../config.yaml');
        $kernel->handleOptions($options);

        return $kernel;
    }

    public function testCommandWithInvalidInput()
    {
        $this->application = new Application($this->getKernelClass());
        $command = $this->getContainer()->get(OTPCommand::class);
        $this->application->add($command);
        $command = $this->application->find('tm:om:otp');
        $command = (new CommandTester($command));
        $this->assertEquals(Command::FAILURE, $command->execute([
            'msisdn' => '77878787',
            'pin' => '202d'
        ]));
        $display = $command->getDisplay();
        $this->assertStringContainsString('Your input is invalid', $display);
    }

    public function testCommandWithValidInput()
    {
        $this->application = new Application($this->getKernelClass());
        $command = $this->getContainer()->get(OTPCommand::class);
        $this->application->add($command);
        $command = $this->application->find('tm:om:otp');
        $command = (new CommandTester($command));
        $this->assertEquals(0, $command->execute([
            'msisdn' => '786175701',
            'pin' => '2021'
        ]));
        $display = $command->getDisplay();
        //TODO: Complete the otp test code
    }
}
