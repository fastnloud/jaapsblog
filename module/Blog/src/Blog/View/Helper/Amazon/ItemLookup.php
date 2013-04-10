<?php

namespace Blog\View\Helper\Amazon;

use Zend\View\Helper\AbstractHelper;

class ItemLookup extends AbstractHelper
{

    /**
     * Amazon itemLookup view helper.
     *
     * @param $options array
     * @return string HMTL string
     */
    public function render($amazon, array $options = array(), $cacheId)
    {
        $obj = $amazon->itemLookup($options, $cacheId);

        if (is_object($obj)) {
            $item   = $obj->Items->Item;
            $href   = $item->ItemLinks->ItemLink[0]->URL;
            $title  = $this->view->escapeHtml($item->ItemAttributes->Title);

            return <<<ITEM
<div class="amazon-item-lookup">
    <a target="_blank" href="{$href}" title="{$title}">
        <img src="{$item->MediumImage->URL}" alt="{$title}">
    </a>
    <p style="width:{$item->MediumImage->Width->_}px">
        <a target="_blank" href="{$href}" title="Buy on Amazon">Buy on Amazon</a>
    </p>
</div>
ITEM;
        } else {
            return $obj;
        }
    }
}