<?php

namespace WShafer\OpenGraph\Validator;

use Zend\Validator\Exception;
use Zend\Validator\ValidatorInterface;

class OpenGraphValidator implements ValidatorInterface
{
    protected $messages = [];
    
    public function isValid($value)
    {
        $ogType = !empty($value['general']['ogType']) ? $value['general']['ogType'] : '';

        $ogTypeValidator = new OgTypeValidator();
        if (!$ogTypeValidator->isValid($ogType)) {
            $this->messages = $ogTypeValidator->getMessages();
            return false;
        }
        
        $typeValidator = $this->getValidatorsForType($ogType);
        
        if (!$typeValidator) {
            $this->messages[] = 'Unable to find validator for type: '.$ogType;
            return false;
        }
        
        if (!$typeValidator->isValid($value)) {
            $this->messages = array_merge($this->messages, $typeValidator->getMessages());
            return false;
        }
        
        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    protected function getValidatorsForType($type)
    {
        if (empty($type)) {
            return null;
        }
        
        switch ($type) {
            case 'website':
                return new WebSiteValidator();
            case 'article':
                return new ArticleValidator();
        }
    }
}
