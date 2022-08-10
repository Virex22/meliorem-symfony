<?php
namespace App\Service;

use App\Entity\FavoriteCourse;

class FavoriteCourseService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return FavoriteCourse::class;
    }

    public function create(Array $data) : FavoriteCourse
    {
        $this->validateRequiredData($data, 'addDate', 'userId','courseId');
        $favoriteCourse = $this->createEntity($data, 'addDate', 'userId','courseId');
    
        return $favoriteCourse;
    }


    public function edit(object $favoriteCourse ,Array $data) : FavoriteCourse
    {
        $this->editEntity($favoriteCourse, $data, 'addDate', 'userId','courseId');
        
        return $favoriteCourse;
    }
}