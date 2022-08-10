<?php
namespace App\Service;

use App\Entity\CoursePartQuiz;

class CoursePartQuizService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return CoursePartQuiz::class;
    }

    public function create(Array $data) : CoursePartQuiz
    {
        $this->validateRequiredData($data, 'quizId', 'coursePartId');
        $coursePartQuiz = $this->createEntity($data, 'quizId', 'coursePartId');
    
        return $coursePartQuiz;
    }


    public function edit(object $coursePartQuiz ,Array $data) : CoursePartQuiz
    {
        $this->editEntity($coursePartQuiz, $data, 'quizId', 'coursePartId');
        
        return $coursePartQuiz;
    }
}