<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Group;
use App\Entity\Student;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{

    
    public function testStudentConstructorGetterAndSetter(){
        $user = new User();
        $group = new Group();
        $student = new Student();

        $student->setUser($user)
            ->setGroupReference($group);

        $this->assertNull($student->getId());
        $this->assertNull($student->getUserId());
        $this->assertSame($user, $student->getUser());
        $this->assertSame($group, $student->getGroupReference());
    }


}

