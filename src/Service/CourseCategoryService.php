<?php
namespace App\Service;

use App\Entity\CourseCategory;

class CourseCategoryService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return CourseCategory::class;
    }

    public function create(Array $data) : CourseCategory
    {
        $this->validateRequiredData($data, 'name', 'color');
        $courseCategory = $this->createEntity($data, 'name', 'color');
    
        return $courseCategory;
    }


    public function edit(object $courseCategory ,Array $data) : CourseCategory
    {
        $this->editEntity($courseCategory, $data, 'name', 'color');
        
        return $courseCategory;
    }
}