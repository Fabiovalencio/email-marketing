<?php

namespace CodeEmailMKT\Application\Form;

use CodeEmailMKT\Domain\Entity\Customer;
use Zend\Form\Element\Button;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Hydrator\ClassMethods;


class CustomerForm extends Form
{
    public function __construct($name = 'customer', array $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods());
        $this->setObject(new Customer());

        $this->add([
            'name' => 'id',
            'type' => Hidden::class
        ]);

        $this->add([
            'name' => 'name',
            'type' => Text::class,
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
            'type' => Email::class,
            'options' => [
                'label' => 'E-mail:'
            ],
            'attributes' => [
                'id' => 'email',
                'class' => 'form-control',
                'required' => 'required'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Button::class,
            'attributes' => [
                'type' => 'submit'
            ]
        ]);
    }

}