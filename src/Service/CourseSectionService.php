<?php
namespace App\Service;

use App\Entity\CourseSection;

class CourseSectionService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return CourseSection::class;
    }

    public function create(Array $data) : CourseSection
    {
        $this->validateRequiredData($data, 'name', 'courseOrder','courseId');
        $courseSection = $this->createEntity($data, 'name', 'courseOrder','courseId');
    
        return $courseSection;
    }


    public function edit(object $courseSection ,Array $data) : CourseSection
    {
        $this->editEntity($courseSection, $data, 'name', 'courseOrder','courseId');
        
        return $courseSection;
    }
}