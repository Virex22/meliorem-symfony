<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Student;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StudentRepositoryTest extends KernelTestCase {


    public function testStudentRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $studentRepository = $em->getRepository(Student::class);
        $userRepository = $em->getRepository(User::class);

        $user = new User();
        $user->setEmail("studeeent@meliorem.fr")
            ->setPassword("test")
            ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
            ->setName("test")
            ->setFirstName("test")
            ->setImage("test")
            ->setActivated(true)
            ->setCreatedAt(new \DateTime());
        $userRepository->add($user,true);

        $student = new Student();
        $student->setUser($user);

        $studentRepository->add($student,true);
        $newStudent = $studentRepository->findBy(['user' => $user])[0];
        $this->assertEquals($newStudent->getUser(), $user);
        $studentRepository->remove($student,true);
        $userRepository->remove($user,true);
        $newStudent = $studentRepository->findBy(['user' => $user]);
        $this->assertEmpty($newStudent);

    }

}