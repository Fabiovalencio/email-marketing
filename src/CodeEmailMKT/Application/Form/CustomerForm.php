<?php

namespace CodeEmailMKT\Application\Form;

use CodeEmailMKT\Domain\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Element;
use Zend\Form\Form;


class CustomerForm extends Form implements ObjectManagerAwareInterface
{
    private $objectManager;

    public function __construct($name = 'customer', array $options = [])
    {
        parent::__construct($name, $options);

    }

    public function init()
    {
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
            'name' => 'tags',
            'type' => ObjectSelect::class,
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class'   => Tag::class,
                'property'       => 'name',
            ],
            'attributes' => [
                'id' => 'tags',
                'class' => 'form-control select2 select2-hidden-accessible',
                'multiple' => 'multiple',
                'data-placeholder' => 'Selecione uma tag'
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

    /**
     * Set the object manager
     *
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Get the object manager
     *
     * @return  ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}