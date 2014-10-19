<?php

namespace Session\Service;

use Zend\Session\Container;

class SessionManager extends \Zend\Session\SessionManager
{

    /**
     * Initialize manager & attach validators.
     *
     * @param array $config
     */
    public function init(array $config = array())
    {
        if (isset($config['validators'])) {
            $this->attachValidators($config['validators']);
        }

        Container::setDefaultManager($this);
    }

    /**
     * Attach validators.
     *
     * @param $validators
     */
    protected function attachValidators($validators)
    {
        $chain = $this->getValidatorChain();

        foreach ($validators as $validator) {
            $validator = new $validator();
            $chain->attach('session.validate', array($validator, 'isValid'));
        }
    }

}