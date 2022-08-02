<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StudentRepositoryTest extends KernelTestCase {


    public function testStudentRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $studentRepository = $em->getRepository(Student::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}