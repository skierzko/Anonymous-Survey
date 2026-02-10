<?php

namespace App\Repository;

use App\Entity\SurveyResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SurveyResult>
 */
class SurveyResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SurveyResult::class);
    }

    /**
     * @return SurveyResult[]
     */
    public function findBySurveyId(int $surveyId): array
    {
        return $this->createQueryBuilder('sr')
            ->andWhere('sr.survey = :surveyId')
            ->setParameter('surveyId', $surveyId)
            ->orderBy('sr.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLatestForSurvey(int $surveyId): ?SurveyResult
    {
        return $this->createQueryBuilder('sr')
            ->andWhere('sr.survey = :surveyId')
            ->setParameter('surveyId', $surveyId)
            ->orderBy('sr.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return SurveyResult[]
     */
    public function findActiveBySurveyId(int $surveyId): array
    {
        return $this->createQueryBuilder('sr')
            ->andWhere('sr.survey = :surveyId')
            ->andWhere('sr.deletedAt IS NULL')
            ->setParameter('surveyId', $surveyId)
            ->orderBy('sr.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function softDelete(SurveyResult $result): void
    {
        $result->setDeletedAt(new \DateTimeImmutable());
        $this->getEntityManager()->flush();
    }
}
