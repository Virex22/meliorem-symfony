<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePartDocument;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartDocumentRepositoryTest extends KernelTestCase {


    public function testCoursePartDocumentRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartDocumentRepository = $em->getRepository(CoursePartDocument::class);
        
        $coursePartDocument = new CoursePartDocument();
        $coursePartDocument->setContent('CoursePartDocument 1');

        $coursePartDocumentRepository->add($coursePartDocument,true);
        $newCoursePartDocument = $coursePartDocumentRepository->findBy(['content' => 'CoursePartDocument 1'])[0];
        $coursePartDocumentRepository->remove($coursePartDocument,true);
        $newCoursePartDocument = $coursePartDocumentRepository->findBy(['content' => 'CoursePartDocument 1']);
        $this->assertEmpty($newCoursePartDocument);




    }

}