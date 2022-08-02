<?php

namespace App\Tests\Unit\Repository;

use App\Entity\CoursePartDocument;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoursePartDocumentRepositoryTest extends KernelTestCase {


    public function testCoursePartDocumentRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $coursePartDocumentRepository = $em->getRepository(CoursePartDocument::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}