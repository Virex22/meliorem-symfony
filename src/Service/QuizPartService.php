<?php
namespace App\Service;

use App\Entity\QuizPart;

class QuizPartService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return QuizPart::class;
    }

    public function create(Array $data) : QuizPart
    {
        $this->validateRequiredData($data, 'question', 'choice','answer','timeMaxToResponse','quizOrder','skillId','quizId');
        $quizPart = $this->createEntity($data,'question', 'choice','answer','timeMaxToResponse','quizOrder','skillId','quizId');
    
        return $quizPart;
    }


    public function edit(object $quizPart ,Array $data) : QuizPart
    {
        $this->editEntity($quizPart, $data, 'question', 'choice','answer','timeMaxToResponse','quizOrder','skillId','quizId');
        
        return $quizPart;
    }
}