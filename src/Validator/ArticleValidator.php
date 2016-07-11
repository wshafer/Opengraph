<?php

namespace WShafer\OpenGraph\Validator;

use Zend\Validator\Exception;
use Zend\Validator\NotEmpty;
use Zend\Validator\Uri;
use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

class ArticleValidator implements ValidatorInterface
{
    protected $image;
    
    protected $notEmptyValidator;

    protected $messages = [];

    public function __construct()
    {
        $this->notEmptyValidator = new NotEmpty();
        
        $this->image = new ValidatorChain();
        $this->image->attach($this->notEmptyValidator);
        $this->image->attach(new Uri());
    }

    public function isValid($value)
    {
        if (empty($value['website']['image'])
            || !$this->image->isValid($value['website']['image'])
        ) {
            $this->messages = array_merge($this->messages, $this->image->getMessages());
        }
        
        if (empty($value['website']['title'])) {
            $this->messages[] = 'Missing Web Page Title';
        }

        if (empty($value['website']['description'])) {
            $this->messages[] = 'Missing Web Page Description';
        }
        
        if (!empty($this->messages)) {
            return false;
        }
        
        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
