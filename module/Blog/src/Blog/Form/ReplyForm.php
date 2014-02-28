<?php

namespace Blog\Form;

use Zend\Form\Form;

class ReplyForm extends Form
{

    public function __construct($name = null)
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