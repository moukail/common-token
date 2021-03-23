<?php

namespace Moukail\CommonToken\Generator;

class TokenGenerator
{
    /**
     * @var string Unique, random, cryptographically secure string
     */
    private $signingKey;

    /**
     * @var RandomGenerator
     */
    private $randomGenerator;

    public function __construct(string $signingKey, RandomGenerator $generator)
    {
        $this->signingKey = $signingKey;
        $this->randomGenerator = $generator;
    }

    /**
     * Get a cryptographically secure token with it's non-hashed components.
     *
     * @param mixed  $userId   Unique user identifier
     * @param string $verifier Only required for token comparison
     */
    public function createToken(\DateTimeInterface $expiresAt, $userId, string $verifier = null): TokenComponents
    {
        if (null === $verifier) {
            $verifier = $this->randomGenerator->getRandomAlphaNumStr();
        }

        $selector = $this->randomGenerator->getRandomAlphaNumStr();

        $encodedData = \json_encode([$verifier, $userId, $expiresAt->getTimestamp()]);

        return new TokenComponents(
            $selector,
            $verifier,
            $this->getHashedToken($encodedData)
        );
    }

    private function getHashedToken(string $data): string
    {
        return \base64_encode(\hash_hmac('sha256', $data, $this->signingKey, true));
    }
}
