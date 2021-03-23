<?php

namespace Moukail\CommonToken\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface TokenInterface
{
    public function __construct(UserInterface $user, \DateTimeInterface $expiresAt, string $token);

    public function getId(): ?int;

    public function getUser(): UserInterface;

    public function getToken(): string;

    public function getCreatedAt(): \DateTimeInterface;

    public function isExpired(): bool;

    public function getExpiresAt(): \DateTimeInterface;
}
