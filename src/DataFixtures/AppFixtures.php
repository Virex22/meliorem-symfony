<?php

namespace App\DataFixtures;

use App\Entity\Notification;
use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\ReceivedNotification;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Time;

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
    private UserService $userService;

    public function __construct(UserPasswordHasherInterface $hasher,UserService $userService)
    {
        $this->hasher = $hasher;
        $this->faker = Factory::create('fr_FR');
        $this->userService = $userService;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $users = [];

        $users[] = $this->createStudent(5);
        $users[] = $this->createSpeaker(5);
        $users[] = $this->createUser(["ROLE_ADMINISTRATION"],5,"administration");
        $users[] = $this->createUser(["ROLE_SUPERADMIN"],5,"superadmin");
        $this->createQuiz(5);
        $notification = $this->createNotification(5);
        foreach ($notification as $notif) 
            $this->createReceivedNotification($this->faker->range(1,5) ,$notif,$this->faker->randomElement($users));


        $manager->flush();
    }

    public function createNotification(int $count): Array
    {
        $notifications = [];
        for ($i = 0; $i < $count; $i++) {
            $notification = new Notification();
            $notification->setTitle($this->faker->sentence(3))
                ->setDescription($this->faker->text(200))
                ->setInteraction($this->faker->paragraph());
            $this->manager->persist($notification);
            $notifications[] = $notification;
        }
        return $notifications;
    }

    public function createReceivedNotification(int $count, Notification $notification, User $user): Array
    {
        $receivedNotifications = [];
        for ($i = 0; $i < $count; $i++) {
            $receivedNotification = new ReceivedNotification();
            $receivedNotification->setViewed(false)
                ->setNotification($notification)
                ->setUser($user);
            $this->manager->persist($receivedNotification);
            $receivedNotifications[] = $receivedNotification;
        }
        return $receivedNotifications;
    }

    public function createQuiz(int $count){
        for ($i=0; $i < $count; $i++) { 
            $quizPartCount = $this->faker->numberBetween(1,10);
            echo "Creating quiz $i with $quizPartCount quiz part \n";
            $quiz = new Quiz();
            $quiz->setDescription($this->faker->paragraph)
            ->setPublic(true)
            ->setCreatedAt($this->faker->dateTime)
            ->setTimeToPerformAll($this->faker->numberBetween(100,1000));
            
            $this->createQuizPart($quiz,$quizPartCount);

            $this->manager->persist($quiz);
        }
    }

    public function createQuizPart(Quiz $quiz, int $count){
        for ($i=0; $i < $count; $i++) { 
            $quizPart = new QuizPart();
            $quizPart->setQuestion($this->faker->paragraph)
            ->setChoice(json_encode([
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence,
            ]))
            ->setAnswer(json_encode(
                [
                    $this->faker->numberBetween(0,3),
                    $this->faker->numberBetween(0,3),
                ]
            ))
            ->setTimeMaxToResponse($this->faker->numberBetween(10,100))
            ->setQuizOrder($i)
            ->setQuiz($quiz);

            $this->manager->persist($quizPart);
        }
        return;
    }

    public function createUser($role,$count,$mailPrefix){
        $returnUsers = [];
        for ($i=0; $i < $count; $i++) {
            echo "Creating user $mailPrefix $i\n"; 
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

    public function createStudent($count){
        $returnUsers = [];
        for ($i=0; $i < $count; $i++) { 
            echo "Creating student $i\n";
            $user = new User();
            $user->setEmail("student$i@meliorem.fr")
            ->setRoles(["ROLE_STUDENT"])
            ->setFirstname($this->faker->firstName())
            ->setName($this->faker->name())
            ->setImage("https://picsum.photos/1000/700")
            ->setPassword($this->hasher->hashPassword($user, 'azerty'));

            $this->userService->createPair($user);
            $returnUsers[] = $user;
            $this->manager->persist($user);
        }
        return $returnUsers;
    }

    public function createSpeaker($count){
        $returnUsers = [];
        for ($i=0; $i < $count; $i++) { 
            echo "Creating speaker $i\n";
            $user = new User();
            $user->setEmail("speaker$i@meliorem.fr")
            ->setRoles(["ROLE_SPEAKER"])
            ->setFirstname($this->faker->firstName())
            ->setName($this->faker->name())
            ->setImage("https://picsum.photos/1000/700")
            ->setPassword($this->hasher->hashPassword($user, 'azerty'));

            $this->userService->createPair($user);
            $returnUsers[] = $user;
            $this->manager->persist($user);
        }
        return $returnUsers;
    }
}
