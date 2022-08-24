<?php
namespace App\DTO;

use App\Entity\Contact;
use App\Entity\ReceivedNotification;
use App\Entity\Student;
use App\Entity\User;

/**
 * Class UserDTO
 * @package App\DTO
 * User entity with only the necessary data to be sent to the client (without the password)
 */
class UserDTO
{
    private $id;
    private $email;
    private $roles;
    private $contact;
    private $receivedNotifications;
    private $student;
    private $speaker;
    private $name;
    private $firstname;
    private $image;
    private $badges;
    private $skillUserXPs;
    private $quizPartPerforms;
    private $readLaters;
    private $favoriteCourses;

    public function hydrate(User $user)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
        $this->roles = $user->getRoles();
        $this->contact = $user->getContact();
        $this->receivedNotifications = $user->getReceivedNotifications();
        $this->student = $user->getStudent();
        $this->speaker = $user->getSpeaker();
        $this->name = $user->getName();
        $this->firstname = $user->getFirstname();
        $this->image = $user->getImage();
        $this->badges = $user->getBadges();
        $this->skillUserXPs = $user->getSkillUserXPs();
        $this->quizPartPerforms = $user->getQuizPartPerforms();
        $this->readLaters = $user->getReadLaters();
        $this->favoriteCourses = $user->getFavoriteCourses();
    }

    public function getData()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
            'contact' => $this->contact,
            'receivedNotifications' => $this->receivedNotifications,
            'student' => $this->student,
            'speaker' => $this->speaker,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'image' => $this->image,
            'badges' => $this->badges,
            'skillUserXPs' => $this->skillUserXPs,
        ];
    }
}