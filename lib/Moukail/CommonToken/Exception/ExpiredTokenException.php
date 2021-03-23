<?php

namespace Moukail\CommonToken\Exception;

class ExpiredTokenException extends \Exception implements ExceptionInterface
{
    public function getReason(): string
    {
        return 'The link in your mail is expired. Please try again';
    }
}
