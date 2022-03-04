<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;
use Payplug\Bundle\PaymentBundle\DependencyInjection\PayplugPaymentExtension;

/**
 * @internal
 */
class PayplugPaymentExtensionTest extends ExtensionTestCase
{
    public function testLoad(): void
    {
        $this->loadExtension(new PayplugPaymentExtension());

        $expectedDefinitions = [
            'payplug.event_listener.callback.checkout_listener',
            'payplug.generator.payplug_config_identifier',
            'payplug.integration.channel',
            'payplug.integration.transport',
            'payplug.factory.payplug_config',
            'payplug.payment_method.config.provider',
            'payplug.factory.method_view.payplug',
            'payplug.payment_method_view_provider.payplug',
            'payplug.service.gateway',
            'payplug.factory.method.payplug',
            'payplug.payment_method_provider.payplug',
            'payplug.datagrid.order_payment_transactions.action_permission_provider',
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);

        $expectedParameters = [
            'payplug.method.identifier_prefix',
        ];
        $this->assertParametersLoaded($expectedParameters);
    }
}
