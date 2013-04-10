<?php

namespace Blog\View\Helper\Amazon;

use Zend\View\Helper\AbstractHelper;

class ItemSearch extends AbstractHelper
{

    /**
     * Amazon itemSearch view helper.
     * Max. 10 items.
     *
     * @param $options array
     * @return string HMTL string
     */
    public function render($amazon, array $options = array(), $cacheId)
    {
        $obj = $amazon->itemSearch($options, $cacheId);

        if (is_object($obj)) {
            $items = $obj->Items->Item;

            foreach ($items as $key => $item) {
                if ($key == 5) { break; }

                $href       = $item->ItemLinks->ItemLink[0]->URL;
                $title      = $this->view->escapeHtml($item->ItemAttributes->Title);
                $titleShort = $title;

                $movies[] = "<li><a href=\"$href\" title=\"$title\" target=\"_blank\">{$titleShort}</a></li>";
            }
        } else {
            return $obj;
        }

        return "<ul>".implode($movies,PHP_EOL)."</ul>";
    }
}