<?php

namespace App\Repository;

use App\Entity\SurveyQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SurveyQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SurveyQuestion::class);
    }

    public function findVisibleForSurvey(int $surveyId): array
    {
        return $this->createQueryBuilder('q')
            ->join('q.survey', 's')
            ->andWhere('s.id = :surveyId')
            ->andWhere('q.visible = true')
            ->andWhere('q.deletedAt IS NULL')
            ->setParameter('surveyId', $surveyId)
            ->orderBy('q.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
