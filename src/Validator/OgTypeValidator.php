<?php

namespace WShafer\OpenGraph\Validator;

use Zend\Validator\Exception;
use Zend\Validator\NotEmpty;
use Zend\Validator\Uri;
use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

class OgTypeValidator implements ValidatorInterface
{
    protected $type;
    
    protected $message = 'og:type is invalid';

    protected $messages = [];

    protected $types = [
        'website',
        'music.song',
        'music.album',
        'music.playlist',
        'music.radio_station',
        'video.movie',
        'video.episode',
        'video.tv_show',
        'video.other',
        'article',
        'book',
        'profile'
    ];

    public function isValid($value)
    {
        if (!in_array($value, $this->types)) {
            $this->messages[] = $this->message;
            return false;
        }
        
        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
