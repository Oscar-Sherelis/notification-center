<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByFilters(
        ?string $country,
        ?bool $isPremium,
        ?\DateTimeImmutable $lastActiveAfter,
        ?string $platform
    ): array {
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('u.devices', 'd')
            ->addSelect('d');

        if ($country) {
            $qb->andWhere('u.countryCode = :country')
                ->setParameter('country', $country);
        }

        if ($isPremium !== null) {
            $qb->andWhere('u.isPremium = :premium')
                ->setParameter('premium', $isPremium);
        }

        if ($lastActiveAfter) {
            $qb->andWhere('u.lastActiveAt >= :date')
                ->setParameter('date', $lastActiveAfter);
        }

        if ($platform) {
            $qb->andWhere('d.platform = :platform')
                ->setParameter('platform', $platform);
        }

        return $qb->getQuery()->getResult();
    }
}
