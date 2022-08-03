<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Group;
use App\Entity\Student;
use App\Entity\User;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StudentServiceTest extends KernelTestCase {

    public function testService() {
        $kernel = self::bootKernel();
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(Student::class);
        $repositoryGroup = $kernel->getContainer()->get('doctrine')->getRepository(Group::class);
        $service = $kernel->getContainer()->get(StudentService::class);

        $valeursDeBase = new Group();
        $valeursDeBase->setName('maValeursDeBase');
        $repositoryGroup->add($valeursDeBase,true);
        $group = $repositoryGroup->findBy(['name' => 'maValeursDeBase'])[0];

        $valeursModifier = new Group();
        $valeursModifier->setName('maValeursModifier');
        $repositoryGroup->add($valeursModifier,true);
        $groupModifier = $repositoryGroup->findBy(['name' => 'maValeursModifier'])[0];

        $student = new Student();
        $student->setGroupReference($group);
        $repository->add($student,true);
        $student = $repository->findBy(['groupReference' => $group])[0];
        $service->edit($student, [
            'groupId' =>  $groupModifier->getId(),
        ]);
        $student = $repository->findBy(['groupReference' => $groupModifier])[0];
        $this->assertEquals($groupModifier, $student->getGroupReference());
        $repository->remove($student,true);
        $repositoryGroup->remove($valeursModifier,true);
        $repositoryGroup->remove($valeursDeBase,true);
    }

    public function testMyEntityServiceException(){
        $kernel = self::bootKernel();
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(Student::class);
        $repositoryGroup = $kernel->getContainer()->get('doctrine')->getRepository(Group::class);
        $service = $kernel->getContainer()->get(StudentService::class);

        $valeursDeBase = new Group();
        $valeursDeBase->setName('maValeursDeBase');
        $repositoryGroup->add($valeursDeBase,true);
        $group = $repositoryGroup->findBy(['name' => 'maValeursDeBase'])[0];

        $student = new Student();
        $student->setGroupReference($group);
        $repository->add($student,true);
        $student = $repository->findBy(['groupReference' => $group])[0];
        $this->expectException(\Exception::class);
        $service->edit($student, [
            'groupId' =>  5468546545,
        ]);
    }
}
