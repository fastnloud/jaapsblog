<?php

namespace Blog\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class UrlString extends AbstractHelper
{

    /**
     * Convert string to URL string. Used to generate
     * friendly URL's.
     * 
     * @param string $string
     * @param bool $suffix
     * @return string
     */
    public function __invoke($string, $suffix = true)
    {
        $urlString = strtolower($string);
        $urlString = preg_replace('/[^a-z0-9]+/i', '-', $urlString);
        $urlString = preg_replace('/-$/', '', $urlString);

        // return with suffix
        if (true === $suffix) {
            return $urlString . '.html';
        }

        // return without suffix and strip if needed
        return (preg_match('/.html$/i', $urlString) ? substr($urlString,0,-5) : $urlString);
    }

}