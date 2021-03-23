<?php

namespace Moukail\CommonToken\Exception;

class InvalidTokenException extends \Exception implements ExceptionInterface
{
    public function getReason(): string
    {
        return 'The link in your mail is invalid. Please try again';
    }
}
