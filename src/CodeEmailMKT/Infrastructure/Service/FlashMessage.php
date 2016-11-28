<?php

namespace CodeEmailMKT\Infrastructure\Service;

use CodeEmailMKT\Domain\Service\FlashMessageInterface;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class FlashMessage implements FlashMessageInterface
{

    /**
     * @var $flashMessenger
     */
    private $flashMessenger;

    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function setNamespace(string $name = __NAMESPACE__)
    {
        $this->flashMessenger->setNamespace($name);
        return $this;
    }

    public function setMessage($key, string $value)
    {
        switch ($key){
            case self::MESSAGE_SUCCESS:
                $this->flashMessenger->addSuccessMessage($value);
                break;
            case self::MESSAGE_ERROR:
                $this->flashMessenger->addErrorMessage($value);
                break;
        }
        return $this;
    }

    public function getMessage($key)
    {
        $result = null;
        switch ($key){
            case self::MESSAGE_SUCCESS:
                $result = $this->flashMessenger->getCurrentSuccessMessages();
                break;
            case self::MESSAGE_ERROR;
                $result = $this->flashMessenger->getCurrentErrorMessages();
                break;
        }
        return count($result) ? $result[0] : null;
    }

}