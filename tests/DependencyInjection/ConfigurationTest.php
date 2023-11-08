<?php
namespace Tm\OrangeMoneyBundle\Test\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Tm\OrangeMoneyBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
        $this->defaultConfigExpected = [
            'client_id' => 'test',
            'client_secret' => 'test',
            'environment' => 'sandbox'
        ];
    }

    public function testBundleProcessConfiguration()
    {
        $config = $this->processor->processConfiguration($this->configuration, ['orange_money' => $this->defaultConfigExpected]);

        $this->assertEquals($this->defaultConfigExpected, $config);
    }

    public function testBundleProcessConfigurationWrongConfig()
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->processor->processConfiguration($this->configuration, ['orange_money' => [$this->defaultConfigExpected, 'more' => 'morevalue']]);
    }

}