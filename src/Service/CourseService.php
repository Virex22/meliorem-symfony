<?php
namespace App\Service;

use App\Entity\Course;

class CourseService extends AbstractEntityService
{
    use DeleteTrait;

    public function getEntitiesArray($id) : array{
        $course = $this->em->getRepository(Course::class)->find($id);
        $courseSection = $course->getCourseSections();
        $courseParts = array_map(function($courseSection){
            return $courseSection->getCourseParts();
        }, $courseSection->toArray());
        return [
           $courseParts,
           $courseSection,
           $courseParts,
        ];
    }

    protected function getEntityClass() : string
    {
        return Course::class;
    }

    public function create(Array $data) : Course
    {
        $this->validateRequiredData($data, 'speakerId', 'title','description','publishDate','lastEditDate','image','isPublic');
        $course = $this->createEntity($data, 'speakerId', 'title','description','publishDate','lastEditDate','image','isPublic');
        
        return $course;
    }


    public function edit(object $course ,Array $data) : Course
    {
        $this->editEntity($course, $data, 'speakerId', 'title','description','publishDate','lastEditDate','image','isPublic');
        
        return $course;
    }
}