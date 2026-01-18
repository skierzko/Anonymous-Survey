<?php

namespace App\Repository;

use App\Entity\SurveyQuestionOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SurveyQuestionOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SurveyQuestionOption::class);
    }

    public function findVisibleByQuestion(int $questionId): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.question = :questionId')
            ->andWhere('o.visible = true')
            ->andWhere('o.deletedAt IS NULL')
            ->setParameter('questionId', $questionId)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
