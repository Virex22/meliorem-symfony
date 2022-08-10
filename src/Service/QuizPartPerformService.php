<?php
namespace App\Service;

use App\Entity\QuizPartPerform;

class QuizPartPerformService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return QuizPartPerform::class;
    }

    public function create(Array $data) : QuizPartPerform
    {
        $this->validateRequiredData($data, 'timeToResponse','score','userId', 'quizPartId');
        if (!isset($data['date']))
            $data['date'] = new \DateTime();
        $quizPartPerform = $this->createEntity($data, 'timeToResponse','score','userId', 'quizPartId','date');
    
        return $quizPartPerform;
    }


    public function edit(object $quizPartPerform ,Array $data) : QuizPartPerform
    {
        $this->editEntity($quizPartPerform, $data,  'timeToResponse','score','userId', 'quizPartId','date');
        
        return $quizPartPerform;
    }
}