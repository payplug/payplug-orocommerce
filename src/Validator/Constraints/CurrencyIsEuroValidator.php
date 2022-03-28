<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Validator\Constraints;

use Oro\Bundle\PaymentBundle\Entity\PaymentMethodConfig;
use Oro\Bundle\PaymentBundle\Entity\PaymentMethodsConfigsRule;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;
use Payplug\Bundle\PaymentBundle\Method\Payplug;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CurrencyIsEuroValidator extends ConstraintValidator
{
    public const VALID_CURRENCY = 'EUR';

    /**
     * @var PaymentMethodProviderInterface
     */
    protected $paymentMethodProvider;

    public function __construct(PaymentMethodProviderInterface $paymentMethodProvider)
    {
        $this->paymentMethodProvider = $paymentMethodProvider;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!($value instanceof PaymentMethodsConfigsRule)) {
            return;
        }

        /** @var PaymentMethodConfig $methodConfig */
        foreach ($value->getMethodConfigs() as $methodConfig) {
            $paymentMethod = $this->paymentMethodProvider->getPaymentMethod($methodConfig->getType());

            if ($paymentMethod instanceof Payplug && self::VALID_CURRENCY !== $value->getCurrency()) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('currency')
                    ->addViolation();
            }
        }
    }
}
