<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\SurveyRepository;
use App\Dto\Survey\CreateSurveyRequest;
use App\Service\SurveyService;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/user', name: 'user', methods: ['GET'])]
    public function me(#[CurrentUser] ?User $user): JsonResponse
    {
        if (!$user) {
            return $this->json([
                'error' => 'User is not logged.'
            ], 401);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);
    }

    #[Route('/surveys', name: 'surveys', methods: ['GET'])]
    public function surveysByUser(
        #[CurrentUser] ?User $user,
        SurveyRepository $surveyRepository,
    ): JsonResponse {
        $surveys = $surveyRepository->findBy(['userId' => $user->getId()]);

        return $this->json(
            $surveys,
            status: 200,
            headers: [],
            context: ['groups' => ['user:read']]
        );
    }

    #[Route('/survey/{id}', name: 'survey', methods: ['GET'])]
    public function surveysByUserAndId(
        #[CurrentUser] ?User $user,
        SurveyRepository $surveyRepository,
        int $id,
    ): JsonResponse {
        $survey = $surveyRepository->findBy([
            'userId' => $user->getId(),
            'id' => $id,
            'deletedAt' => null
            ]);

        return $this->json(
            $survey,
            status: 200,
            headers: [],
            context: ['groups' => ['user:read']]
        );
    }

    #[Route('/survey/save', name: 'save', methods: ['POST'])]
    public function save(
        #[CurrentUser]
        ?User $user,
        #[MapRequestPayload]
        CreateSurveyRequest $request,
        SurveyService $surveyService,
        EntityManagerInterface $em
    ): JsonResponse {
        if (!$user) {
            return $this->json([
                'error' => 'User is not logged.'
            ], 401);
        }

        $survey = $surveyService->saveSurvey($request, $em);

        return $this->json(
            $survey,
            status: 200,
            headers: [],
            context: ['groups' => ['user:read']]
        );
    }

    #[Route('/survey/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteSurvey(
        #[CurrentUser]
        ?User $user,
        int $id,
        SurveyRepository $surveyRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        if (!$user) {
            return $this->json([
                'error' => 'User is not logged.'
            ], 401);
        }

        $survey = $surveyRepository->findOneBy([
            'id' => $id,
            'userId' => $user->getId(),
            'deletedAt' => null
        ]);

        if (!$survey) {
            return $this->json([
                'error' => 'Survey not found.'
            ], 404);
        }

        $survey->softDelete();
        $em->persist($survey);
        $em->flush();

        return $this->json([
            'success' => true
        ]);
    }
}