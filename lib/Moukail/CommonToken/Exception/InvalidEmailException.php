<?php

namespace Moukail\CommonToken\Exception;

class InvalidEmailException extends \Exception implements ExceptionInterface
{
    public function getReason(): string
    {
        return 'The email is invalid. Please try again';
    }
}
