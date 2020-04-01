<?php

namespace Kiwee\Bundle\CategorydescBundle\Catalog\Normalizer\Standard;

use Akeneo\Component\Classification\Model\CategoryInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategoryNormalizer implements NormalizerInterface
{
    /** @var TranslationNormalizer */
    protected $translationNormalizer;

    /**
     * @param TranslationNormalizer $translationNormalizer
     */
    public function __construct(TranslationNormalizer $translationNormalizer)
    {
        $this->translationNormalizer = $translationNormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($category, $format = null, array $context = [])
    {
        return [
            'code' => $category->getCode(),
            'parent' => null !== $category->getParent() ? $category->getParent()->getCode() : null,
            'labels' => $this->translationNormalizer->normalize($category, 'standard', $context),
            'urlkey' => $this->translationNormalizer->normalizeAttribute($category, 'urlkey', 'standard', $context),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof CategoryInterface && 'standard' === $format;
    }
}
