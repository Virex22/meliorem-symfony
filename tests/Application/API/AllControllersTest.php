<?php 

namespace App\tests\Application\API;

use App\Entity\Badge;
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
use App\Entity\Student;
use App\Entity\TypeContact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerGetTest extends WebTestCase
{
    private $token;
    private $client;

    public function setUp(): void{
        self::ensureKernelShutdown();
        $client = static::createClient();
        $this->client = $client;
        $client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"superadmin0@meliorem.fr","password":"azerty"}');
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->token = $data["token"];
    }



    public function provideUrls(){
        yield [[
            "path" => 'badge',
            "class" => Badge::class,
            "data" => [
                "name" => "test",
                "description" => "test",
                "image" => "test",
                "UserId" => $this->getEntityId(User::class),
                "ignoreMy" => "juste test for ignore path"
            ],
            "edit" => ["key" => "name", "value" => "test2"]
            ]];
        yield [[
            "path" => 'contact',
            "class" => TypeContact::class,
            "data" => [
                "phone" => "test",
                "description" => "test",
                "userID" => $this->getEntityId(User::class),
                "typeContactId" => $this->getEntityId(TypeContact::class)
            ]
            ]];
        yield [[
            "path" => 'course',
            "class" => Course::class,
            [
                "title" => "test",
                "description" => "test",
                "publishDate" => "2021-10-31T08:44:40+00:00",
                "lastEditDate" => "2021-10-31T08:44:40+00:00",
                "image" => "test",
                "isPublic" => true,
                "speakerId" => $this->getEntityId(Speaker::class)
            ]
            ]];
        yield [[
            "path" => 'course-category',
            "class" => CourseCategory::class,
            "data" => [
                "name" => "test",
                "color" => "#058762",
            ]
            ]];
        yield [[
            "path" => 'course-part',
            "class" => CoursePart::class,
            "data" => [
                "title" => "title",
                "orderPart" => 1,
                "estimatedTime" => 20,
                "courseSectionId"=> $this->getEntityId(CourseSection::class),
            ]
            ]];
        yield [[
            "path" => 'course-part-document',
            "class" => CoursePartDocument::class,
            "data" => [
                "linkVideo" => "title",
                "content" => "description",
                "files" => "files",
                "coursePartId"=> $this->getEntityId(CoursePart::class),
            ]
            ]];
        yield [[
            "path" => 'course-part-quiz',
            "class" => CoursePartQuiz::class,
            "data" => [
                "quizId" => $this->getEntityId(Quiz::class),
                "coursePartId"=> $this->getEntityId(CoursePart::class),
            ]
            ]];
        yield [[
            "path" => 'course-section',
            "class" => CourseSection::class,
            "data" => [
                "name" => "test",
                "courseOrder" => 1,
                "courseId"=> $this->getEntityId(Course::class),
            ]
            ]];
        yield [[
            "path" => 'favorite-course',
            "class" => FavoriteCourse::class,
            "data" => [
                "courseId" => $this->getEntityId(Course::class),
                "userId"=> $this->getEntityId(User::class),
                "addDate" => "2021-10-31T08:44:40+00:00",
            ]
            ]];
        yield [[
            "path" => 'group',
            "class" => Group::class,
            "data" => [
                "name" => "test",
                "studentId" => [$this->getEntityId(Student::class)],
                "coursesId" => $this->getEntityId(Course::class),
            ]
            ]];
        yield [[
            "path" => 'notification',
            "class" => Notification::class,
            "data" => [
                "title" => "test",
                "description" => "test",
                "interaction" => '[{"type":"link","value":"https://www.google.com/"}]',
            ]
            ]];
        yield [[
            "path" => 'quiz',
            "class" => Quiz::class,
            "data" => [
                "title" => "test",
                "description" => "test",
                "public" => true,
                "timeToPerformAll" => 245,
            ]
            ]];
        yield [[
            "path" => 'quiz-part',
            "class" => QuizPart::class,
            "data" => [
                "question" => "test",
                "choice" => "test",
                "answer" => "test",
                "timeMaxToResponse" => 245,
                "quizOrder" => 1,
                "quizPartPerforms" => [],
                "skillId" => $this->getEntityId(Skill::class),
                "quizId" => $this->getEntityId(Quiz::class),
            ]
            ]];
        yield [[
            "path" => 'quiz-part-perform',
            "class" => QuizPartPerform::class,
            "data" => [
                "timeToResponse" => 245,
                "score" => 1,
                "userId" => $this->getEntityId(User::class),
                "quizPartId" => $this->getEntityId(QuizPart::class),
            ]
            ]];
        yield [[
            "path" => 'read-later',
            "class" => ReadLater::class,
            "data" => [
                "positionOrder" => 1,
                "userId" => $this->getEntityId(User::class),
                "courseId" => $this->getEntityId(Course::class),
            ]
            ]];
        yield [[
            "path" => 'received-notification',
            "class" => ReceivedNotification::class,
            "data" => [
                "notificationId" => $this->getEntityId(Notification::class),
                "userId" => $this->getEntityId(User::class),
                "viewed" => true,
            ]
            ]];
        yield [[
            "path" => 'skill',
            "class" => Skill::class,
            "data" => [
                "name" => "test",
                "description" => "test",
                "xpRequiredForLevels" => "[{1:2},{2:5},{3:15},{4:50},{5:100}]",
            ]
            ]];
        yield [[
            "path" => 'skill-user-xp',
            "class" => SkillUserXP::class,
            "data" => [
                "skillId" => $this->getEntityId(Skill::class),
                "userId" => $this->getEntityId(User::class),
                "xp" => 5,
            ]
            ]];
        yield [[
            "path" => 'speaker',
            "class" => Speaker::class
            ]];
        yield [[
            "path" => 'speciality',
            "class" => Speciality::class,
            "data" => [
                "name" => "test",
                "speakerId" => $this->getEntityId(Speaker::class),
            ]
            ]];
        yield [[
            "path" => 'student',
            "class" => Student::class
            ]];
        yield [[
            "path" => 'type-contact',
            "class" => TypeContact::class,
            "data" => [
                "name" => "test",
            ]
            ]];
        yield [[
            "path" => 'user',
            "class" => User::class
            ]];
    }
    protected function getEntityId($class){
        return $this->getContainer()->get('doctrine')->getRepository($class)->findAll()[0]->getId();
    }

    /**
     * @dataProvider provideUrls
     */
    public function testCrud($data){
        // get all
        $this->client->request('GET', "https://localhost:8000/api/" . $data["path"] . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));

        // get by id
        $this->client->request('GET', "https://localhost:8000/api/" . $data["path"] . "/" . $this->getEntityId($data["class"]), [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));

        // post
        if (!isset($data["data"]))return;

        $this->client->request('POST', "http://localhost:8000/api/" . $data["path"] . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ],json_encode($data["data"]));

        $newEntity = json_decode($this->client->getResponse()->getContent(), true);
        if ($this->client->getResponse()->getStatusCode() == 400)
            file_put_contents( __DIR__ ."/error.html", $this->client->getResponse()->getContent());
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertIsInt($newEntity["id"]);
        $id = $newEntity["id"];

        // // patch

        // $this->client->request('PATCH', "http://localhost:8000/api/" . $data["path"] . "/$id", [], [], [
        //     'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        // ],json_encode($data["edit"]));

        // $this->assertEquals(200, $this->client->getResponse()->getStatusCode());





    }

   
}