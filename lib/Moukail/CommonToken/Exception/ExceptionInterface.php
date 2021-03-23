<?php

namespace Moukail\CommonToken\Exception;

interface ExceptionInterface extends \Throwable
{
    public function getReason(): string;
}
