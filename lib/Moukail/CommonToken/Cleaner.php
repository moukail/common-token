<?php

namespace Moukail\CommonToken;

use Moukail\CommonToken\Repository\TokenRepositoryInterface;

class Cleaner
{
    /**
     * @var bool Enable/disable garbage collection
     */
    private $enabled;

    private $repository;

    public function __construct(TokenRepositoryInterface $repository, bool $enabled = true)
    {
        $this->repository = $repository;
        $this->enabled = $enabled;
    }

    /**
     * Clears expired reset password requests from persistence.
     *
     * Enable/disable in configuration. Calling with $force = true
     * will attempt to remove expired requests regardless of
     * configuration setting.
     */
    public function handleGarbageCollection(bool $force = false): int
    {
        if ($this->enabled || $force) {
            return $this->repository->removeExpiredTokenEntities();
        }

        return 0;
    }
}
