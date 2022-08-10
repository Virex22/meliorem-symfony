<?php
namespace App\Service;

use App\Entity\CoursePart;

class CoursePartService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return CoursePart::class;
    }

    public function create(Array $data) : CoursePart
    {
        $this->validateRequiredData($data, 'title', 'orderPart','estimatedTime','courseSectionId');
        $coursePart = $this->createEntity($data, 'title', 'orderPart','estimatedTime','courseSectionId','coursePartDocumentId','coursePartQuizId');
        
        return $coursePart;
    }


    public function edit(object $coursePart ,Array $data) : CoursePart
    {
        $this->editEntity($coursePart, $data, 'title', 'orderPart','estimatedTime','courseSectionId','coursePartDocumentId','coursePartQuizId');
        
        return $coursePart;
    }
}