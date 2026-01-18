<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Dto\Survey\CreateSurveyRequest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Constraints\Valid;

use App\Entity\User;
use App\Service\SurveyService;

#[Route('/survey', name: 'survey_')]
class SurveyController extends AbstractController
{
    #[Route('/save', name: 'save', methods: ['POST'])]
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

        return $this->json([
            'status' => ! empty($survey),
            'surveyId' => $survey->getId(),
        ]);
    }
}