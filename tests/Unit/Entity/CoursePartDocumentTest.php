<?php

namespace App\Tests\Unit\Entity;

use App\Entity\CoursePart;
use App\Entity\CoursePartDocument;
use PHPUnit\Framework\TestCase;

class CoursePartDocumentTest extends TestCase
{

    
    public function testCoursePartDocumentConstructorGetterAndSetter(){

        $coursePart = new CoursePart();
        $coursePart->setEstimatedTime(5445);

        $coursePartDocument = new CoursePartDocument();

        $coursePartDocument->setLinkVideo('linkVideo')
        ->setContent('content')
        ->setFiles('files')
        ->setCoursePart($coursePart);

        $this->assertNull($coursePartDocument->getId());
        $this->assertEquals('linkVideo', $coursePartDocument->getLinkVideo());
        $this->assertEquals('content', $coursePartDocument->getContent());
        $this->assertEquals('files', $coursePartDocument->getFiles());
        $this->assertEquals($coursePart, $coursePartDocument->getCoursePart());
        $this->assertContains(5445,$coursePartDocument->getCoursePartInfo());

        $coursePartDocument->setCoursePart(null);
        $this->assertNull($coursePartDocument->getCoursePartInfo());
    }

}

