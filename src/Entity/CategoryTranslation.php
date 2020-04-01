<?php

namespace Kiwee\Bundle\CategorydescBundle\Entity;

use Pim\Bundle\CatalogBundle\Entity\CategoryTranslation as BaseCategoryTranslation;

class CategoryTranslation extends BaseCategoryTranslation
{
    protected $urlkey;

    public function getUrlkey()
    {
        return $this->urlkey;
    }

    public function setUrlkey($urlkey)
    {
        $this->urlkey = $urlkey;

        return $this;
    }
}