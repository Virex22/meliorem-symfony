<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Badge;
use App\Entity\Contact;
use App\Entity\FavoriteCourse;
use App\Entity\QuizPartPerform;
use App\Entity\ReadLater;
use App\Entity\ReceivedNotification;
use App\Entity\SkillUserXP;
use App\Entity\Speaker;
use App\Entity\Student;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends KernelTestCase
{

    public function testUserConstructorGetterAndSetter() {

        $badge = new Badge();
        $student = new Student();
        $speaker = new Speaker();
        $contact = new Contact();
        $receivedNotification = new ReceivedNotification();
        $skillUserXp = new SkillUserXP();
        $quizPartPerform = new QuizPartPerform();
        $readLater = new ReadLater();
        $favoriteCourse = new FavoriteCourse();
        $user = new User();

        $user->setEmail("test@meliorem.fr")
        ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
        ->setFirstname("test")
        ->setName("test")
        ->setImage("https://test")
        ->setPassword("hash")
        ->setStudent($student)
        ->setSpeaker($speaker)
        ->setContact($contact)
        ->addBadge($badge)
        ->addReceivedNotification($receivedNotification)
        ->addSkillUserXp($skillUserXp)
        ->addQuizPartPerform($quizPartPerform)
        ->addReadLater($readLater)
        ->addFavoriteCourse($favoriteCourse);

        $this->assertContains($receivedNotification, $user->getReceivedNotifications());
        $this->assertContains($skillUserXp, $user->getSkillUserXps());
        $this->assertContains($quizPartPerform, $user->getQuizPartPerforms());
        $this->assertContains($readLater, $user->getReadLaters());
        $this->assertContains($favoriteCourse, $user->getFavoriteCourses());
        $this->assertContains($badge, $user->getBadges());

        $user->removeBadge($badge)
            ->removeReceivedNotification($receivedNotification)
            ->removeSkillUserXp($skillUserXp)
            ->removeQuizPartPerform($quizPartPerform)
            ->removeReadLater($readLater)
            ->removeFavoriteCourse($favoriteCourse);

        $this->assertNotContains($receivedNotification, $user->getReceivedNotifications());
        $this->assertNotContains($skillUserXp, $user->getSkillUserXps());
        $this->assertNotContains($quizPartPerform, $user->getQuizPartPerforms());
        $this->assertNotContains($readLater, $user->getReadLaters());
        $this->assertNotContains($favoriteCourse, $user->getFavoriteCourses());
        $this->assertNotContains($badge, $user->getBadges());

        $this->assertEquals("test@meliorem.fr", $user->getEmail());
        $this->assertEquals(["ROLE_USER", "ROLE_SUPERADMIN"], $user->getRoles());
        $this->assertEquals("test", $user->getFirstname());
        $this->assertEquals("test", $user->getName());
        $this->assertEquals("https://test", $user->getImage());
        $this->assertEquals("hash", $user->getPassword());
        $this->assertEquals($student, $user->getStudent());
        $this->assertEquals($speaker, $user->getSpeaker());
        $this->assertEquals($contact, $user->getContact());
        $this->assertEquals("test@meliorem.fr", $user->getUserIdentifier());
        $this->assertNull($user->getId());

        $user->setContact(null);
        $user->setStudent(null);
        $user->setSpeaker(null);

        $this->assertNull($user->getContact());
        $this->assertNull($user->getStudent());
        $this->assertNull($user->getSpeaker());
    }

}