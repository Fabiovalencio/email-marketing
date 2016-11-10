<?php

namespace CodeEmailMKT\Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class CustomerForm extends Form
{
    public function __construct($name = 'customer', array $options = [])
    {
        parent::__construct($name, $options);



        $this->add([
            'name' => 'id',
            'type' => Element\Hidden::class
        ]);

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Nome:'
            ],
            'attributes' => [
                'id' => 'name',
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'email',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'E-mail:'
            ],
            'attributes' => [
                'id' => 'email',
                'class' => 'form-control',
                'type' => 'email'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Element\Button::class,
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }

}