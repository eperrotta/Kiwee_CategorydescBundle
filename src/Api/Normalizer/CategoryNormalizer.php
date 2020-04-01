<?php

namespace Kiwee\Bundle\CategorydescBundle\Api\Normalizer;

use Akeneo\Component\Classification\Model\CategoryInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategoryNormalizer implements NormalizerInterface
{
    /** @var NormalizerInterface */
    protected $stdNormalizer;

    protected $customNormalizer;

    /**
     * @param NormalizerInterface $stdNormalizer
     */
    public function __construct(NormalizerInterface $stdNormalizer, NormalizerInterface $customNormalizer)
    {
        $this->stdNormalizer = $stdNormalizer;
        $this->customNormalizer = $customNormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($category, $format = null, array $context = [])
    {
        $normalizedCategory = $this->customNormalizer->normalize($category, 'standard', $context);

        if (empty($normalizedCategory['labels'])) {
            $normalizedCategory['labels'] = (object)$normalizedCategory['labels'];
        }

        return $normalizedCategory;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof CategoryInterface && 'external_api' === $format;
    }
}
