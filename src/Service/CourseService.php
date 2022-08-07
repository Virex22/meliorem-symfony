<?php
namespace App\Service;

use App\Entity\Course;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class CourseService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function getCategoriesByIDs(array $categories)
    {
        try {
            foreach ($categories as $category){
                $category = $this->em->getRepository('App:Category')->find($category);
                if ($category === null)
                    throw new \Exception("CategoryIds $category not found");
                yield $category;
            }
        } catch (\Throwable $th) {
            throw new \Exception('"categoriesIds" is not a array with valid IDs');
        }
        
    }

    public function create(Array $data) : Course
    {
        if (!isset($data['name']))
            throw new \Exception('"name" is required');
        if (!isset($data['description']))
            throw new \Exception('"description" is required');
        if (!isset($data['image']))
            throw new \Exception('"image" is required');
        if (!isset($data['isPublic']))
            throw new \Exception('"isPublic" is required');
        if (!isset($data['speakerId']))
            throw new \Exception('"speakerId" is required');
        $speaker = $this->em->getRepository('App\Entity\User')->find($data['speakerId']);
        if ($speaker === null)
            throw new \Exception('Speaker not found');
        if (!isset($data['categoriesIds']))
            throw new \Exception('"categoriesIds" is required');

        $categories = $this->getCategoriesByIDs($data['categoriesIds']);
        
        $date = new DateTime();
        $course = new Course();
        $course->setTitle($data['name'])
        ->setDescription($data['description'])
        ->setPublishDate($date)
        ->setLastEditDate($date)
        ->setImage($data['image'])
        ->setIsPublic($data['isPublic'])
        ->setSpeaker($speaker);

        foreach ($categories as $category) {
            $course->addCategory($category);
        }
        
        $this->em->persist($course);
        $this->em->flush();
        
        return $course;
    }

    public function update(Course $course, Array $courseData) : Course
    {
        if (isset($courseData['name']))
            $course->setTitle($courseData['name']);
        if (isset($courseData['description']))
            $course->setDescription($courseData['description']);
        if (isset($courseData['image']))
            $course->setImage($courseData['image']);
        if (isset($courseData['isPublic']))
            $course->setIsPublic($courseData['isPublic']);
        if (isset($courseData['speakerId']))
        {
            $speaker = $this->em->getRepository('App\Entity\User')->find($courseData['speakerId']);
            if ($speaker === null)
                throw new \Exception('Speaker not found');
            $course->setSpeaker($speaker);
        }

        // remove all existent categories
        foreach ($course->getCategory() as $category) {
            $course->removeCategory($category);
        }
        // add new categories
        if (isset($courseData['categoriesIds'])) {
            $categories = $this->getCategoriesByIDs($courseData['categoriesIds']);
            foreach ($categories as $category)
                $course->addCategory($category);
        }
        
        
        $this->em->persist($course);
        $this->em->flush();
        
        return $course;
    }

}