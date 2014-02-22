<?php

namespace Blog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $blog = new Blog();
        $blog->setConfig($serviceLocator->get('Config'));
        $blog->setSmtpOptions($serviceLocator->get('SmtpOptions'));
        $blog->setDkimSigner($serviceLocator->get('DkimSigner'));
        $blog->setNavigation($serviceLocator->get('Navigation'));
        $blog->setRequest($serviceLocator->get('Request'));
        $blog->setBlogTable($serviceLocator->get('BlogTable'));
        $blog->setReplyTable($serviceLocator->get('ReplyTable'));
        $blog->setReplyForm($serviceLocator->get('ReplyForm'));

        return $blog;
    }

}