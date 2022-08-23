<?php

namespace App\DataFixtures;

use App\Entity\Badge;
use App\Entity\Contact;
use App\Entity\Course;
use App\Entity\CourseCategory;
use App\Entity\CoursePart;
use App\Entity\CoursePartDocument;
use App\Entity\CoursePartQuiz;
use App\Entity\CourseSection;
use App\Entity\FavoriteCourse;
use App\Entity\Group;
use App\Entity\Notification;
use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\QuizPartPerform;
use App\Entity\ReadLater;
use App\Entity\ReceivedNotification;
use App\Entity\Skill;
use App\Entity\SkillUserXP;
use App\Entity\Speaker;
use App\Entity\Speciality;
use App\Entity\TypeContact;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Time;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
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
        $skills = $this->createSkill(5);


        $users[]= $this->createStudent(5);
        $users[]= $speakers = $this->createSpeaker(5);
        $users[]= $this->createUser(["ROLE_ADMINISTRATION"],5,"administration");
        $users[]= $this->createUser(["ROLE_SUPERADMIN"],5,"superadmin");
        $buff = $users;
        
        $users = []; // flat the user array
            foreach ($buff as $user)
                foreach ($user as $u) 
                    $users[]= $u;

        $badges = $this->createBadge(5,$users);
        
        [$quizs,$quizParts] = $this->createQuiz(15,$skills);
        $notification = $this->createNotification(5);
        foreach ($notification as $notif)
            $this->createReceivedNotification($this->faker->numberBetween(1,5) ,$notif,$this->faker->randomElement($users));
        $contactTypes = $this->createContactType(5);
        $contacts = [];
        foreach ($users as $user)
            if ($this->faker->boolean(40))
                $contacts[] = $this->createContact($this->faker->randomElement($contactTypes) ,$user);
        foreach ($speakers as $speaker)
            $this->createSpeciality($this->faker->numberBetween(1,5),$speaker->getSpeaker());
        $groups = $this->createGroup(5,$users);
        $courses = $this->createCourse(5,$speakers,$groups);
        $this->createCourseCategory(5,$courses);
        $courseSections = $this->createCourseSection(20,$courses,$quizs);

        $this->createReadLater(25,$users,$courses);
        $this->createFavoriteCourse(25,$users,$courses);
        $this->createSkillUserXP(25,$users,$skills);
        $this->createQuizPartPerform(25,$users,$quizParts);
        
        $manager->flush();
    }

     public function createQuizPartPerform(int $count,array $users, array $quizParts ): array
     {
         $quizPartPerforms = [];
         for ($i=0; $i < $count; $i++) { 
            echo "create quiz part perform : $i\n";
             $quizPartPerform = new QuizPartPerform();
             $quizPartPerform->setQuizPart($this->faker->randomElement($quizParts));
             $quizPartPerform->setUser($this->faker->randomElement($users));
             $quizPartPerform->setScore($this->faker->numberBetween(0,100));
             $quizPartPerform->setTimeToResponse($this->faker->numberBetween(0,100));
             $quizPartPerform->setDate($this->faker->dateTimeBetween('-1 years'));
             $this->manager->persist($quizPartPerform);
             $quizPartPerforms[] = $quizPartPerform;
         }
         return $quizPartPerforms;
     }

    public function createSkillUserXP(int $count,array $users, array $skills): array
    {
        $skillUserXPs = [];
        for ($i = 0; $i < $count; $i++) {
            echo "create skill user xp : $i\n";
            $skillUserXP = new SkillUserXP();
            $skillUserXP->setSkill($this->faker->randomElement($skills));
            $skillUserXP->setUser($this->faker->randomElement($users));
            $skillUserXP->setXp($this->faker->numberBetween(0,100));
            $this->manager->persist($skillUserXP);
            $skillUserXPs[] = $skillUserXP;
        }
        return $skillUserXPs;
    }

    public function createReadLater(int $count,array $users,array $courses): array
    {
        $readLaters = [];
        for ($i=0; $i < $count; $i++) { 
            echo "create ReadLater : $i\n";
            $readLater = new ReadLater();
            $readLater->setUser($this->faker->randomElement($users))
            ->setCourse($this->faker->randomElement($courses))
            ->setAddDate($this->faker->dateTimeBetween('-1 years','now'))
            ->setPositionOrder($this->faker->numberBetween(1,100));
            $this->manager->persist($readLater);
            $readLaters[] = $readLater;
        }
        return $readLaters;
    }

    public function createFavoriteCourse(int $count,array $users,array $courses): void
    {
        for ($i = 0; $i < $count; $i++) {
            echo "create FavoriteCourse : $i\n";
            $favoriteCourse = new FavoriteCourse();
            $favoriteCourse->setCourse($this->faker->randomElement($courses))
                ->setUser($this->faker->randomElement($users))
                ->setAddDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $this->manager->persist($favoriteCourse);
        }
    }

    public function createGroup(int $count): array
    {
        $groups = [];
        for ($i = 0; $i < $count; $i++) {
            $group = new Group();
            $group->setName($this->faker->name);
            $this->manager->persist($group);
            $groups[] = $group;
        }
        return $groups;
    }

    public function createCourseCategory(int $count,array $course): array
    {
        $categories = [];
        for ($i = 0; $i < $count; $i++) {
            $category = new CourseCategory();
            $category->setName($this->faker->word);
            $category->setColor($this->faker->hexColor);
            $category->addCourse($this->faker->randomElement($course));
            $this->manager->persist($category);
            $categories[] = $category;
        }
        return $categories;
    }

    public function createBadge(int $count,array $users){
        $badges = [];
        for ($i = 0; $i < $count; $i++) {
            echo "create Badge : $i\n";
            $badge = new Badge();
            $badge->setName($this->faker->name);
            $badge->setDescription($this->faker->text);
            $badge->setImage($this->faker->imageUrl());
            for ($j = 0; $j < $this->faker->numberBetween(1,5); $j++)
                $badge->addUser($this->faker->randomElement($users));
            $this->manager->persist($badge);
            $badges[] = $badge;
        }
        return $badges;
    }


    public function createCourseSection(int $count,array $course,array $quiz): array{
        $courseSections = [];
        for ($i=0; $i < $count; $i++) { 
            echo "create CourseSection : $i\n";
            $courseSection = new CourseSection();
            $courseSection->setName($this->faker->sentence(3));
            $courseSection->setCourseOrder($this->faker->numberBetween(1,10));
            $courseSection->setCourse($this->faker->randomElement($course));
            $this->manager->persist($courseSection);
            $this->createCoursePart($this->faker->numberBetween(1,3),$courseSection,$quiz);
            $courseSections[] = $courseSection;
        }
        return $courseSections;
    }
    public function createCoursePartDocument() : CoursePartDocument{
        $coursePartDocument = new CoursePartDocument();
        $coursePartDocument->setContent($this->faker->text)
        ->setFiles("/path/to/file")
        ->setLinkVideo($this->faker->url);
        return $coursePartDocument;
    }
    public function createCoursePartQuiz(array $quiz) : CoursePartQuiz{
        $coursePartQuiz = new CoursePartQuiz();
        $coursePartQuiz->setQuiz($this->faker->randomElement($quiz));
        return $coursePartQuiz;
    }

    public function createCoursePart(int $count,CourseSection $courseSection,array $quiz): array{
        $courseParts = [];
        for ($i=0; $i < $count; $i++) { 
            echo "create course part : $i\n";
            $coursePart = new CoursePart();
            $coursePart->setEstimatedTime($this->faker->numberBetween(1,10));
            $coursePart->setOrderPart($this->faker->numberBetween(1,10));
            $coursePart->setCourseSection($courseSection);
            $coursePart->setTitle($this->faker->sentence(3));
            if ($this->faker->boolean(75))
                $coursePart->setCoursePartDocument($this->createCoursePartDocument());
            else
                $coursePart->setCoursePartQuiz($this->createCoursePartQuiz($quiz));

            $this->manager->persist($coursePart);
            $courseParts[] = $coursePart;
        }
        return $courseParts;
    }

    public function createCourse(int $count,array $speakers, array $groups)
    {
        $courses = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating course : $i\n";
            $course = new Course();
            $course->setTitle($this->faker->sentence(3));
            $course->setDescription($this->faker->text(200));
            $course->setPublishDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $course->setLastEditDate($this->faker->dateTimeBetween('-1 years', 'now'));
            $course->setImage($this->faker->imageUrl());
            $course->setIsPublic($this->faker->boolean(50));
            $course->setSpeaker($this->faker->randomElement($speakers)->getSpeaker());
            for ($j = 0; $j < $this->faker->numberBetween(1,5); $j++)
                $course->addGroup($this->faker->randomElement($groups));
            $this->manager->persist($course);
            $courses[] = $course;
        }
        return $courses;
    }

    public function createSkill(int $count): array
    {
        $skills = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating skill ".$i."\n";
            $skill = new Skill();
            $skill->setName($this->faker->unique()->word)
                ->setDescription($this->faker->text(100))
                ->setXpRequiredForLevels($this->faker->paragraph());
            $this->manager->persist($skill);
            $skills[] = $skill;
        }
        return $skills;
    }

    public function createSpeciality(int $count,Speaker $speaker): array
    {
        static $nbSpeakers = 0;
        $nbSpeakers++;
        $specialities = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating speciality $i for speaker $nbSpeakers \n";
            $speciality = new Speciality();
            $speciality->setName($this->faker->unique()->word)
                ->setBeginAt($this->faker->dateTimeBetween('-1 years', 'now'))
                ->setSpeaker($speaker);
            $this->manager->persist($speciality);
            $specialities[] = $speciality;
        }
        return $specialities;
    }

    public function createContact(TypeContact $contactType,User $user): Contact
    {
        echo "Creating contact for user ".$user->getFirstname()." ". $user->getName() . "\n";
        $contact = new Contact();
        $contact->setTypeContact($contactType)
            ->setUser($user)
            ->setDescription($this->faker->text(100))
            ->setPhone($this->faker->phoneNumber);
        $this->manager->persist($contact);
        return $contact;
    }

    public function createContactType(int $count): array
    {
        $contactTypes = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating contact type $i\n";
            $contactTypes[] = new TypeContact();
            $contactTypes[$i]->setName($this->faker->unique()->word);
            $this->manager->persist($contactTypes[$i]);
        }
        return $contactTypes;
    }

    public function createNotification(int $count): Array
    {
        $notifications = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating notification $i\n";
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
        static $passage = 0;
        $passage++;
        $receivedNotifications = [];
        for ($i = 0; $i < $count; $i++) {
            echo "Creating received notification $i for user $passage\n";
            $receivedNotification = new ReceivedNotification();
            $receivedNotification->setViewed(false)
                ->setNotification($notification)
                ->setUser($user);
            $this->manager->persist($receivedNotification);
            $receivedNotifications[] = $receivedNotification;
        }
        return $receivedNotifications;
    }

    public function createQuiz(int $count, array $skills) : array{
        $quizzes = [];
        $quizParts = [];
        for ($i=0; $i < $count; $i++) { 
            $quizPartCount = $this->faker->numberBetween(1,10);
            echo "Creating quiz $i with $quizPartCount quiz part \n";
            $quiz = new Quiz();
            $quiz->setDescription($this->faker->paragraph)
            ->setPublic(true)
            ->setTitle($this->faker->sentence(3))
            ->setCreatedAt($this->faker->dateTime)
            ->setTimeToPerformAll($this->faker->numberBetween(100,1000));
            
            $quizParts[] = $this->createQuizPart($quiz,$quizPartCount,$skills);

            $this->manager->persist($quiz);
            $quizzes[] = $quiz;
        }
        $buff = $quizParts;
        $quizParts = [];
        foreach ($buff as $quiz)
                foreach ($quiz as $q) 
                    $quizParts[]= $q;
        return [$quizzes, $quizParts];
    }

    public function createQuizPart(Quiz $quiz, int $count,array $skills) : array{
        $quizParts = [];
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
            ->setSkill($this->faker->randomElement($skills))
            ->setQuiz($quiz);

            $this->manager->persist($quizPart);
            $quizParts[] = $quizPart;
        }
        return $quizParts;
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
            ->setImage("https://picsum.photos/id/". $this->faker->numberBetween(1,1000) ."/500/500")
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
            ->setImage("https://picsum.photos/id/". $this->faker->numberBetween(1,1000) ."/500/500")
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
            ->setImage("https://picsum.photos/id/". $this->faker->numberBetween(1,1000) ."/500/500")
            ->setPassword($this->hasher->hashPassword($user, 'azerty'));

            $this->userService->createPair($user);
            $returnUsers[] = $user;
            $this->manager->persist($user);
        }
        return $returnUsers;
    }
}
