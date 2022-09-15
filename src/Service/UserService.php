<?php
namespace App\Service;

use App\Entity\Speaker;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;
    use DeleteTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getEntitiesArray($id) : array{
        $user = $this->em->getRepository(User::class)->find($id);
        $favoriteCourses = $user->getFavoriteCourses();
        $readLaters = $user->getReadLaters();
        $skillsUserXp = $user->getSkillUserXPs();
        return [
            $favoriteCourses,
            $readLaters,
            $skillsUserXp,
        ];
    }
    
    /**
     * @param User $user
     * @return User
     * 
     * create a Student or Speaker entity for a User entity
     */
    public function createPair(User $user) : User
    {
        if(in_array('ROLE_STUDENT', $user->getRoles()) && !$user->getStudent()) {
          $student = new Student();
          $user->setStudent($student);
          $this->em->persist($student);
        } 
        elseif ($user->getStudent())
            $this->em->remove($user->getStudent());
        if(in_array('ROLE_SPEAKER', $user->getRoles()) && !$user->getSpeaker()) {
          $speaker = new Speaker();
          $user->setSpeaker($speaker);
          $this->em->persist($speaker);
        }
        elseif ($user->getSpeaker())
            $this->em->remove($user->getSpeaker());
        return $user;
    }

    /**
     * @param User $user
     * @return void
     * 
     * delete a User entity
     */
    public function deleteUser(User $user)
    {
        if($user->getStudent() !== null)
            $this->em->remove($user->getStudent());
        if($user->getSpeaker() !== null)
            $this->em->remove($user->getSpeaker());

        $this->delete($user, $this->em);
    }

    /**
     * @param Array $parameters
     * @return User
     * 
     * create a User entity
     */
    public function createUser(array $parameters){
        $user = new User();
        if (empty($parameters['email']))
            throw new \Exception('Email is required');
        if (empty($parameters['password']))
            throw new \Exception('Password is required');
        if (empty($parameters['firstname']))
            throw new \Exception('First name is required');
        if (empty($parameters['name']))
            throw new \Exception('Last name is required');
        if (empty($parameters['roles']))
            throw new \Exception('Roles name is required');

        $user->setEmail($parameters['email']);
        $user->setPassword($parameters['password']);
        $user->setFirstName($parameters['firstname']);
        if (isset($parameters['image']))
            $user->setImage($parameters['image']);
        if (isset($parameters['createdAt']))
            $user->setCreatedAt($parameters['createdAt']);
        else 
            $user->setCreatedAt(new \DateTime());
        if (isset($parameters['activated']))
            $user->setActivated($parameters['activated']);
        else
            $user->setActivated(false);
        $user->setName($parameters['name']);
        $user->setRoles($parameters['roles']);
        if(in_array('ROLE_STUDENT', $parameters['roles']))
            $this->createPair($user);
        else if(in_array('ROLE_SPEAKER', $parameters['roles']))
            $this->createPair($user);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * @param User $user
     * @param Array $parameters
     * @return User
     * 
     * edit a User entity
     */
    public function editUser(User $user, array $parameters){
        if (isset($parameters['email']))
            $user->setEmail($parameters['email']);
        if (isset($parameters['firstname']))
            $user->setFirstName($parameters['firstname']);
        if (isset($parameters['image']))
            $user->setImage($parameters['image']);
        if (isset($parameters['name']))
            $user->setName($parameters['name']);
        if (isset($parameters['roles'])){
            $user->setRoles($parameters['roles']);
            $this->createPair($user);
        }
        if (isset($parameters['activated']))
            $user->setActivated($parameters['activated']);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
}
?>