<?php
namespace App\Service;

use App\Entity\Quiz;
use DateTime;

class QuizService extends AbstractEntityService
{
    use DeleteTrait;

    public function getDeleteAttributes() : array
    {
        return ['quizParts'];
    }
    
    protected function getEntityClass() : string
    {
        return Quiz::class;
    }

    public function create(Array $data) : Quiz
    {
        $this->validateRequiredData($data, 'description', 'public','timeToPerformAll','title','speakerId');
        if (!isset($data['createdAt']))
            $data['createdAt'] = new DateTime();
        $quiz = $this->createEntity($data, 'createdAt', 'description', 'public','timeToPerformAll','title','speakerId');
    
        return $quiz;
    }


    public function edit(object $quiz ,Array $data) : Quiz
    {
        $this->editEntity($quiz, $data, 'createdAt', 'description', 'public','timeToPerformAll','title','speakerId');
        
        return $quiz;
    }
}