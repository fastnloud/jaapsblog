<?php

namespace Blog\Form;

use Zend\Captcha\ReCaptcha;
use Zend\Form\Form;

class ReplyForm extends Form
{

    /**
     * Initialize form with config.
     *
     * @param string $name
     * @param array $config
     */
    public function __construct($name, array $config)
    {
        parent::__construct('reply-form');

        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '#reply-form');

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'captcha' => new ReCaptcha(array(
                    'public_key'  => $config['recaptcha']['public_key'],
                    'private_key' => $config['recaptcha']['private_key'],
                ))
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'comment',
            'options' => array(
                'label' => 'Comment',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Reply',
            ),
        ));
    }

}