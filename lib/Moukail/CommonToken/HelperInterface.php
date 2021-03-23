<?php

namespace Moukail\CommonToken;

use Moukail\CommonToken\Entity\TokenInterface;
use Moukail\CommonToken\Exception\ExceptionInterface;

interface HelperInterface
{
    /**
     * @param object $user
     * @return TokenInterface
     * @throws ExceptionInterface
     */
    public function generateTokenEntity(object $user): TokenInterface;

    /**
     * @param string $fullToken selector string + verifier string provided by the user
     *
     * @throws ExceptionInterface
     */
    public function validateTokenAndFetchUser(string $fullToken): object;

    /**
     * @param string $fullToken selector string + verifier string provided by the user
     */
    public function removeTokenEntity(string $fullToken): void;

    /**
     * Get the length of time in seconds a token is valid.
     */
    public function getTokenLifetime(): int;
}
