<?php

namespace Kiwee\Bundle\CategorydescBundle\Catalog\Normalizer\Standard;

use Akeneo\Component\Localization\Model\TranslatableInterface;
use Akeneo\Component\StorageUtils\Repository\IdentifiableObjectRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationNormalizer implements NormalizerInterface
{
    /** @var IdentifiableObjectRepositoryInterface */
    private $localeRepository;

    public function __construct(IdentifiableObjectRepositoryInterface $localeRepository = null)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $context = array_merge(
            [
                'property' => 'label',
                'locales' => [],
            ],
            $context
        );

        $translations = array_fill_keys($context['locales'], null);
        $method = sprintf('get%s', ucfirst($context['property']));

        foreach ($object->getTranslations() as $translation) {
            // TODO merge: remove null in master
            if (null !== $this->localeRepository) {
                $locale = $this->localeRepository->findOneByIdentifier($translation->getLocale());
                if (null === $locale || !$locale->isActivated()) {
                    continue;
                }
            }

            if (false === method_exists($translation, $method)) {
                throw new \LogicException(
                    sprintf("Class %s doesn't provide method %s", get_class($translation), $method)
                );
            }

            if (empty($context['locales']) || in_array($translation->getLocale(), $context['locales'])) {
                $translations[$translation->getLocale()] = '' === $translation->$method() ?
                    null : $translation->$method();
            }
        }

        return $translations;
    }

    public function normalizeAttribute($object, $attribute, $format = null, array $context = [])
    {
        $context = array_merge(
            [
                'property' => $attribute,
                'locales' => [],
            ],
            $context
        );

        $translations = array_fill_keys($context['locales'], null);
        $method = sprintf('get%s', ucfirst($context['property']));

        foreach ($object->getTranslations() as $translation) {
            // TODO merge: remove null in master
            if (null !== $this->localeRepository) {
                $locale = $this->localeRepository->findOneByIdentifier($translation->getLocale());
                if (null === $locale || !$locale->isActivated()) {
                    continue;
                }
            }

            if (false === method_exists($translation, $method)) {
                throw new \LogicException(
                    sprintf("Class %s doesn't provide method %s", get_class($translation), $method)
                );
            }

            if (empty($context['locales']) || in_array($translation->getLocale(), $context['locales'])) {
                $translations[$translation->getLocale()] = '' === $translation->$method() ?
                    null : $translation->$method();
            }
        }

        return $translations;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof TranslatableInterface && 'standard' === $format;
    }
}
