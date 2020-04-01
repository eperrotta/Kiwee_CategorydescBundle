<?php

namespace Kiwee\Bundle\CategorydescBundle\Form\Type;

use Pim\Bundle\EnrichBundle\Form\Type\TranslatableFieldType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Pim\Bundle\EnrichBundle\Form\Type\CategoryType as BaseCategoryType;

/**
 * Type for category properties
 */
class CategoryType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'urlkey',
            TranslatableFieldType::class,
            [
                'field'             => 'urlkey',
                'translation_class' => $this->translationDataClass,
                'entity_class'      => $this->dataClass,
                'property_path'     => 'translations',
            ]
        );
    }
}