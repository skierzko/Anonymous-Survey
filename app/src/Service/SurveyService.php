<?php

namespace App\Service;

use App\Entity\Survey;
use App\Entity\SurveyQuestion;
use App\Entity\SurveyQuestionOption;
use App\Dto\Survey\CreateSurveyDto;
use App\Dto\Survey\SurveyResultsDto;
use App\Entity\SurveyResult;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Ulid;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class SurveyService
{
    private \DateTimeImmutable $now;
    private User $user;

    public function __construct(
        private Security $security,
    ) {
        $this->now = new \DateTimeImmutable();
        $this->user = $this->security->getUser();
    }

    function saveSurvey(CreateSurveyDto $dto, EntityManagerInterface $em): Survey
    {
        return $this->saveSurveyData($dto, $em);
    }

    private function saveSurveyData(CreateSurveyDto $dto, EntityManagerInterface $em): Survey
    {
        $survey = null;
        if (!empty($dto->id)) {
            $survey = $em->getRepository(Survey::class)->find($dto->id);
        }

        if (!$survey) {
            $survey = new Survey();
            $survey->setSlug($this->generateSlug());
            $survey->setUserId($this->user->getId());
        }

        $survey->setTitle($dto->title)
            ->setDraft($dto->draft)
            ->setPasswordRequired($dto->passwordRequired)
            ->setPassword($dto->password)
            ->setExtraOptions($dto->extraOptions)
            ->setIsPublic($dto->isPublic);

        $this->saveSurveyQuestionsData($survey, $dto);

        $em->persist($survey);
        $em->flush();

        return $survey;
    }

    private function saveSurveyQuestionsData(Survey $survey, CreateSurveyDto $dto): void
    {
        $existingQuestions = [];
        foreach ($survey->getQuestions() as $q) {
            $existingQuestions[$q->getId()] = $q;
        }

        $newQuestions = [];

        foreach ($dto->questions ?? [] as $questionData) {
            /** @var SurveyQuestion $question */
            if (!empty($questionData['id']) && isset($existingQuestions[$questionData['id']])) {
                $question = $existingQuestions[$questionData['id']];
                unset($existingQuestions[$questionData['id']]);
            } else {
                $question = new SurveyQuestion();
                $question->setUuid($this->htmlSafeHexId());
            }

            $question->setSurvey($survey)
                    ->setType($questionData['type'])
                    ->setTitle($questionData['title'])
                    ->setVisible($questionData['visible'])
                    ->setMinOptionsLimit($questionData['minOptionsLimit'])
                    ->setMaxOptionsLimit($questionData['maxOptionsLimit'])
                    ->setDraft($questionData['draft'])
                    ->setRequired($questionData['required'])
                    ->setOptional($questionData['optional'])
                    ->setPosition($questionData['position'])
                    ->setExtraOptions($questionData['extraOptions'] ?? []);

            $this->saveSurveyQuestionOptions($question, $questionData);

            $survey->addQuestion($question);
            $newQuestions[] = $question;
        }

        foreach ($existingQuestions as $questionToDelete) {
            $questionToDelete->softDelete();
        }
    }

    private function saveSurveyQuestionOptions(SurveyQuestion $question, array $questionData): void
    {
        $existingOptions = [];
        foreach ($question->getOptions() as $o) {
            $existingOptions[$o->getId()] = $o;
        }

        foreach ($questionData['options'] ?? [] as $optionData) {
            if (!empty($optionData['id']) && isset($existingOptions[$optionData['id']])) {
                $option = $existingOptions[$optionData['id']];
                unset($existingOptions[$optionData['id']]);
            } else {
                $option = new SurveyQuestionOption();
                $option->setUuid($this->htmlSafeHexId());
            }

            $option->setQuestion($question)
                ->setTitle($optionData['title'])
                ->setVisible($optionData['visible'])
                ->setPosition($optionData['position'])
                // ->setUpdatedAt($this->now)
                ;

            if (!$option->getId()) {
                // $option->setCreatedAt($this->now);
            }

            $question->addOption($option);
        }

        foreach ($existingOptions as $optionToDelete) {
            $optionToDelete->softDelete();
        }
    }

    private function generateSlug(): string
    {
        return strtolower(Ulid::generate());
    }

    function htmlSafeHexId(): string
    {
        $hex = Uuid::v4()->toHex();

        if (is_numeric($hex[0])) {
            $hex[0] = random_int(0, 1)
                ? chr(random_int(65, 90))
                : chr(random_int(97, 122));
        }

        return $hex;
    }

    function saveResults(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        Survey $survey,
        SurveyResultsDto $results
        ): void
    {
        $jsonRequestData = $serializer->serialize($results, 'json');
        $arrayRequestData = json_decode($jsonRequestData, true);
        

        $surveyResult = new SurveyResult();
        $surveyResult->setResults($arrayRequestData)
            ->setSurvey($survey)
            ->setCreatedAt($this->now)
            ->setUpdatedAt($this->now)
        ;

        $em->persist($surveyResult);
        $em->flush();
    }
}