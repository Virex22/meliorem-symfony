<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * TODO :
     * Badge
     * Contact
     * Course
     * CourseCategory
     * CoursePart
     * CoursePartDocument
     * CoursePartQuiz
     * CourseSection
     * FavoriteCourse
     * Group
     * Notification
     * Quiz
     * QuizPart
     * QuizPartPerformed
     * ReadLater
     * ReceivedNotification
     * Skill
     * SkillUser XP
     * Speaker
     * Speciality
     * Student
     * TypeContact
     * User 
     */
    private ObjectManager $manager;
    private Generator $faker;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createUser(["ROLE_STUDENT"],5,"student");
        $this->createUser(["ROLE_SPEAKER"],5,"speaker");
        $this->createUser(["ROLE_ADMINISTRATION"],5,"administration");
        $this->createUser(["ROLE_SUPERADMIN"],5,"superadmin");

        $manager->flush();
    }

    public function createUser($role,$count,$mailPrefix){
        $returnUsers = [];
        for ($i=0; $i < $count; $i++) { 
            $user = new User();
            $user->setEmail("$mailPrefix$i@meliorem.fr")
            ->setRoles($role)
            ->setFirstname($this->faker->firstName())
            ->setName($this->faker->name())
            ->setImage("https://picsum.photos/1000/700")
            ->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $returnUsers[] = $user;
            $this->manager->persist($user);
        }
        return $returnUsers;
    }

    
    
}
