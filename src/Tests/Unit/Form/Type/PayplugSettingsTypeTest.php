<?php

declare(strict_types=1);

namespace Payplug\Bundle\PaymentBundle\Tests\Unit\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroEncodedPlaceholderPasswordType;
use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Oro\Bundle\LocaleBundle\Tests\Unit\Form\Type\Stub\LocalizedFallbackValueCollectionTypeStub;
use Oro\Bundle\SecurityBundle\Encoder\SymmetricCrypterInterface;
use Oro\Component\Testing\Unit\FormIntegrationTestCase;
use Oro\Component\Testing\Unit\PreloadedExtension;
use Payplug\Bundle\PaymentBundle\Entity\PayplugSettings;
use Payplug\Bundle\PaymentBundle\Form\Type\PayplugSettingsType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Validation;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @internal
 */
class PayplugSettingsTypeTest extends FormIntegrationTestCase
{
    /**
     * @var PayplugSettingsType
     */
    private $formType;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|SymmetricCrypterInterface
     */
    private $encoder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|TranslatorInterface
     */
    private $translator;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->encoder = $this->createMock(SymmetricCrypterInterface::class);

        $this->formType = new PayplugSettingsType();

        parent::setUp();
    }

    public function testGetBlockPrefixReturnsCorrectString(): void
    {
        static::assertSame(PayplugSettingsType::BLOCK_PREFIX, $this->formType->getBlockPrefix());
    }

    public function testSubmit(): void
    {
        $submitData = [
            'labels' => [['string' => 'Payplug']],
            'shortLabels' => [['string' => 'PayplugShort']],
            'login' => 'user',
        ];

        $payplugSettings = new PayplugSettings();

        $form = $this->factory->create(PayplugSettingsType::class, $payplugSettings);

        $form->submit($submitData);

        static::assertTrue($form->isValid());
        static::assertEquals($payplugSettings, $form->getData());
    }

    public function testConfigureOptions(): void
    {
        /** @var OptionsResolver|\PHPUnit\Framework\MockObject\MockObject $resolver */
        $resolver = $this->createMock(OptionsResolver::class);
        $resolver->expects(static::once())
            ->method('setDefaults')
            ->with([
                'data_class' => PayplugSettings::class,
                'allow_extra_fields' => true,
            ]);

        $this->formType->configureOptions($resolver);
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        $localizedType = new LocalizedFallbackValueCollectionTypeStub();

        return [
            new PreloadedExtension(
                [
                    PayplugSettingsType::class => $this->formType,
                    LocalizedFallbackValueCollectionType::class => $localizedType,
                    OroEncodedPlaceholderPasswordType::class => new OroEncodedPlaceholderPasswordType($this->encoder),
                ],
                []
            ),
            new ValidatorExtension(Validation::createValidator()),
        ];
    }
}
