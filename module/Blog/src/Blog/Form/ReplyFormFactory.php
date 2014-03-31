<?php

namespace Blog\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReplyFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $replyForm = new ReplyForm(
            'reply-form',
            $serviceLocator->get('Config')
        );

        return $replyForm;
    }

}