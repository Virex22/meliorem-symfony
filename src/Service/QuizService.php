<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use DateTime;

class QuizService extends AbstractEntityService
{
    use DeleteTrait;

    public function getEntitiesArray($id): array
    {
        $quiz = $this->em->getRepository(Quiz::class)->find($id);
        if (!$quiz)
            throw new \Exception('Quiz not found');
        $quizParts = $quiz->getQuizParts();
        $quizPartPerform = array_map(function ($quizPart) {
            return $quizPart->getQuizPartPerforms();
        }, $quizParts->toArray());

        $entities = [
            $quizParts,
            $quizPartPerform,
            $quiz->getCoursePartQuizzes(),
        ];
        return $entities;
    }

    protected function getEntityClass(): string
    {
        return Quiz::class;
    }

    public function create(array $data): Quiz
    {
        $this->validateRequiredData($data, 'description', 'public', 'timeToPerformAll', 'title', 'speakerId', 'theme');
        if (!isset($data['createdAt']))
            $data['createdAt'] = new DateTime();
        $quiz = $this->createEntity($data, 'createdAt', 'description', 'public', 'timeToPerformAll', 'title', 'speakerId', 'theme');

        return $quiz;
    }


    public function edit(object $quiz, array $data): Quiz
    {
        $this->editEntity($quiz, $data, 'createdAt', 'description', 'public', 'timeToPerformAll', 'title', 'speakerId', 'theme');

        return $quiz;
    }
}
