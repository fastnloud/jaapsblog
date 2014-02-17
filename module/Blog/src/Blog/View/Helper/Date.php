<?php

namespace Blog\View\Helper;
 
use Zend\View\Helper\AbstractHelper;
 
class Date extends AbstractHelper
{

    protected $defaultFormat = 'F j, Y';
    
    /**
     * Returns a given date (string) as a nicely formatted
     * date.
     * 
     * @param string $string
     * @return string date
     */
    public function __invoke($string, $format = null)
    {
        $time = strtotime($string);

        if (false !== $time) {
            if (null === $format) {
                $format = $this->defaultFormat;
            }

            return date($format, $time);
        }
        
        return date($this->defaultFormat);
    }

}