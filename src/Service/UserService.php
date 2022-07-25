<?php
namespace App\Service;

use App\Entity\Speaker;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @param User $user
     * @return void
     * 
     * create a Student entity for a User entity
     */
    public function createStudentPair(User $user)
    {
        if($user->getStudent() !== null )
            return;

        $student = new Student();
        $student->setUser($user);
        $this->em->persist($student);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @return void
     * 
     * create a Speaker entity for a User entity
     */
    public function createSpeakerPair(User $user)
    {
        if($user->getSpeaker() !== null )
            return;
        $speaker = new Speaker();
        $speaker->setUser($user);
        $this->em->persist($speaker);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @return void
     * 
     * delete a User entity
     */
    public function deleteStudent(User $user)
    {
        if($user->getStudent() !== null)
            $this->em->remove($user->getStudent());
            
        $this->em->remove($user);
        $this->em->flush();
    }

}
?>