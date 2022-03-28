<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Service;

class Anonymizer
{
    public const ANONYMIZER_KEYS = [
        'email',
        'first_name',
        'last_name',
        'address1',
        'address2',
        'city',
        'postcode',
    ];

    public function anonymizeArray(array $data): void
    {
        array_walk_recursive($data, [$this, 'anonymizeRecursive']);
    }

    private function anonymizeRecursive(&$item = null, $key = null): void
    {
        if (\in_array($key, self::ANONYMIZER_KEYS, true)) {
            $item = str_pad(mb_substr((string) $item, 0, 1), mb_strlen((string) $item) - 1, '*') . mb_substr((string) $item, -1);
        }
    }
}
