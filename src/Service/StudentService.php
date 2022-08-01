<?php
namespace App\Service;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function edit(Student $student, Array $data) : Student
    {
        if (isset($data['groupId'])){
                $group = $this->em->getRepository('App:Group')->find($data['groupId']);
                if ($group === null)
                    throw new \Exception('Group not found');
                $student->setGroupReference($group);
            }
        $this->em->persist($student);
        $this->em->flush();

        return $student;
    }


}
?>