<?php

namespace Kiwee\Bundle\CategorydescBundle\Entity;

use Akeneo\Pim\Enrichment\Component\Category\Model\Category as BaseCategory;
use Kiwee\Bundle\CategorydescBundle\Entity\CategoryTranslation;

class Category extends BaseCategory
{
    public function getUrlkey()
    {
        $translated = ($this->getTranslation()) ? $this->getTranslation()->getUrlkey() : null;

        return ($translated !== '' && $translated !== null) ? $translated : '[' . $this->getCode() . ']';
    }

    public function setUrlkey($urlkey)
    {
        $this->getTranslation()->setUrlkey($urlkey);

        return $this;
    }

    public function getTranslationFQCN()
    {
        return CategoryTranslation::class;
    }
}
#CONFIG