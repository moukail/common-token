<?php

namespace Moukail\CommonToken\Repository;

use Moukail\CommonToken\Entity\TokenInterface;

trait TokenRepositoryTrait
{
    public function getUserIdentifier(object $user): string
    {
        return '';
    }

    public function getMostRecentNonExpiredRequestDate(object $user): ?\DateTimeImmutable
    {
        /** @var TokenInterface $tokenEntity */
        $tokenEntity = $this->createQueryBuilder('t')
            ->where('t.user = :user')
            ->setParameter('user', $user)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneorNullResult()
        ;

        if (null !== $tokenEntity && !$tokenEntity->isExpired()) {
            return $tokenEntity->getCreatedAt();
        }

        return null;
    }

    public function persistTokenEntity(TokenInterface $tokenEntity): void
    {
        $this->getEntityManager()->persist($tokenEntity);
        $this->getEntityManager()->flush();
    }

    public function findTokenEntity(string $token): ?TokenInterface
    {
        return $this->findOneBy(['token' => $token]);
    }

    public function removeTokenEntity(TokenInterface $tokenEntity): void
    {
        $this->getEntityManager()->remove($tokenEntity);
        $this->getEntityManager()->flush();
    }

    public function removeExpiredTokenEntities(): int
    {
        $time = new \DateTimeImmutable('-1 week');
        $query = $this->createQueryBuilder('t')
            ->delete()
            ->where('t.expiresAt <= :time')
            ->setParameter('time', $time)
            ->getQuery()
        ;

        return $query->execute();
    }
}
