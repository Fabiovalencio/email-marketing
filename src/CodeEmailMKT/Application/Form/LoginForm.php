<?php

namespace CodeEmailMKT\Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;


class LoginForm extends Form
{
    public function __construct($name = 'login', array $options = [])
    {
        parent::__construct($name, $options);

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
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Senha:'
            ],
            'attributes' => [
                'id' => 'password',
                'class' => 'form-control'
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