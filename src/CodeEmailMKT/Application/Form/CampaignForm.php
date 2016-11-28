<?php

namespace CodeEmailMKT\Application\Form;

use CodeEmailMKT\Domain\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Element;
use Zend\Form\Form;


class CampaignForm extends Form implements ObjectManagerAwareInterface
{
    private $objectManager;

    public function __construct($name = 'campaign', array $options = [])
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
            'name' => 'subject',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Assunto:'
            ],
            'attributes' => [
                'id' => 'subject',
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'template',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Template:'
            ],
            'attributes' => [
                'id' => 'template',
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'tags',
            'type' => ObjectSelect::class,
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class'   => Tag::class,
                'property'       => 'name',
                'label'          => 'Tags'
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