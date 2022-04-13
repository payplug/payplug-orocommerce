<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Tests\Unit\Method;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Payplug\Bundle\PaymentBundle\Method\Config\PayplugConfigInterface;
use Payplug\Bundle\PaymentBundle\Method\Payplug;
use Payplug\Bundle\PaymentBundle\Service\Gateway;

/**
 * @internal
 */
class PayplugTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PayplugConfigInterface
     */
    private $config;

    /**
     * @var Gateway
     */
    private $gateway;

    /**
     * @var Payplug
     */
    private $method;

    protected function setUp(): void
    {
        $this->config = $this->createMock(PayplugConfigInterface::class);
        $this->gateway = $this->createMock(Gateway::class);

        $this->method = new Payplug($this->config, $this->gateway);
    }

    public function testGetIdentifier(): void
    {
        $identifier = 'id';

        $this->config->expects(static::once())
            ->method('getPaymentMethodIdentifier')
            ->willReturn($identifier);

        $this->assertEquals($identifier, $this->method->getIdentifier());
    }

    public function testSupports(): void
    {
        $this->assertTrue($this->method->supports(Payplug::PURCHASE));
    }

    public function testIsApplicable(): void
    {
        /** @var PaymentContextInterface|\PHPUnit_Framework_MockObject_MockObject $context */
        $context = $this->createMock(PaymentContextInterface::class);
        $this->assertFalse($this->method->isApplicable($context));

        $this->config->method('isConnected')
            ->willReturn(true);
        $this->assertTrue($this->method->isApplicable($context));
    }

    public function testIsDebugMode(): void
    {
        $this->assertFalse($this->method->isDebugMode());

        $this->config->method('isDebugMode')
            ->willReturn(true);
        $this->assertTrue($this->method->isDebugMode());
    }

    public function testIsConnected(): void
    {
        $this->assertFalse($this->method->isConnected());

        $this->config->method('isConnected')
            ->willReturn(true);
        $this->assertTrue($this->method->isConnected());
    }
}
