<?php

namespace Blog\Form;

use Zend\Form\Form;

class ReplyForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('reply-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '#reply');

        $this->add(array(
            'name' => 'subject',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'subject'
            )
        ));

        $this->add(array(
            'name'     => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));

        $this->add(array(
            'name'     => 'comment',
            'attributes' => array(
                'type' => 'textarea'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Reply',
                'id'    => 'submitbutton',
            ),
        ));
    }
}