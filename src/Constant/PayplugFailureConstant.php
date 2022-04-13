<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Constant;

class PayplugFailureConstant
{
    public const PROCESSING_ERROR = 'processing_error';
    public const CARD_DECLINED = 'card_declined';
    public const INSUFFICIENT_FUNDS = 'insufficient_funds';
    public const IS_3DS_DECLINED = '3ds_declined';
    public const INCORRECT_NUMBER = 'incorrect_number';
    public const FRAUD_SUSPECTED = 'fraud_suspected';
    public const METHOD_UNSUPPORTED = 'method_unsupported';
    public const CARD_SCHEME_MISMATCH = 'card_scheme_mismatch';
    public const CARD_EXPIRATION = 'card_expiration_date_prior_to_last_installment_date';
    public const ABORTED = 'aborted';
    public const TIMEOUT = 'timeout';

    public static function getAll(): array
    {
        return [
            self::PROCESSING_ERROR,
            self::CARD_DECLINED,
            self::INSUFFICIENT_FUNDS,
            self::IS_3DS_DECLINED,
            self::INCORRECT_NUMBER,
            self::FRAUD_SUSPECTED,
            self::METHOD_UNSUPPORTED,
            self::CARD_SCHEME_MISMATCH,
            self::CARD_EXPIRATION,
            self::ABORTED,
            self::TIMEOUT,
        ];
    }
}
