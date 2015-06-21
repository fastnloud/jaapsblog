<?php

namespace Application\Validator;

use Zend\Http\Header\HeaderInterface;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Stdlib\RequestInterface;

/**
 * Class XCrfToken
 * @package Application\Validator
 */
class XCrfToken extends AbstractValidator
{

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Cookie-to-Header Token validation.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value = null)
    {
        if (null === $value) {
            $value = $this->getRequest()->getHeader('X-Csrf-Token');
        } elseif(!$value instanceof HeaderInterface) {
            return false;
        }

        $csrfTokenCookie = $this->getRequest()->getCookie();

        if (!$csrfTokenCookie || !$csrfTokenCookie->offsetExists('Csrf-Token')) {
            return false;
        }

        if ($value->getFieldValue() === $csrfTokenCookie->offsetGet('Csrf-Token')) {
            return true;
        }

        return false;
    }

    /**
     * @param \Zend\Stdlib\RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Zend\Stdlib\RequestInterface
     */
    protected function getRequest()
    {
        return $this->request;
    }

}