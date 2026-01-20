<?php

namespace App\Repository;

use App\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function findPublicActive(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.draft = false')
            ->andWhere('s.deletedAt IS NULL')
            ->andWhere('s.isPublic = 1')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
