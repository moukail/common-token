<?php

namespace Moukail\CommonToken\Repository;

use Moukail\CommonToken\Entity\TokenInterface;

interface TokenRepositoryInterface
{
    /**
     * Create a new ResetPasswordRequest object.
     *
     * @param object $user User entity - typically implements Symfony\Component\Security\Core\User\UserInterface
     * @param \DateTimeInterface $expiresAt
     * @param string $token
     * @return TokenInterface
     */
    public function createTokenEntity(object $user, \DateTimeInterface $expiresAt, string $token): TokenInterface;

    /**
     * Get the unique user entity identifier from persistence.
     *
     * @param object $user User entity - typically implements Symfony\Component\Security\Core\User\UserInterface
     * @return string
     */
    public function getUserIdentifier(object $user): string;

    /**
     * Save a reset password request entity to persistence.
     * @param TokenInterface $tokenEntity
     */
    public function persistTokenEntity(TokenInterface $tokenEntity): void;

    /**
     * Get a reset password request entity from persistence, if one exists, using the request's selector.
     *
     * @param string $selector A non-hashed random string used to fetch a request from persistence
     */
    public function findTokenEntity(string $selector): ?TokenInterface;

    /**
     * Get the most recent non-expired reset password request date for the user, if one exists.
     *
     * @param object $user User entity - typically implements Symfony\Component\Security\Core\User\UserInterface
     * @return \DateTimeInterface|null
     */
    public function getMostRecentNonExpiredRequestDate(object $user): ?\DateTimeImmutable;

    /**
     * Remove this reset password request from persistence and any other for this user.
     *
     * This method should remove this ResetPasswordRequestInterface and also all
     * other ResetPasswordRequestInterface objects in storage for the same user.
     * @param TokenInterface $tokenEntity
     */
    public function removeTokenEntity(TokenInterface $tokenEntity): void;

    /**
     * Remove all expired reset password request objects from persistence.
     *
     * @return int Number of request objects removed from persistence
     */
    public function removeExpiredTokenEntities(): int;
}
