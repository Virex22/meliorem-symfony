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

    public function setUp(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $this->client = $client;
        $client->request(
            'POST',
            'https://localhost:8000/api/login',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"username":"superadmin0@meliorem.fr","password":"azerty"}'
        );

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->token = $data["token"];
    }



    public function provideUrls()
    {

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
            "edit-data" => ["name" => "test2"]
        ]];
        yield [[
            "path" => 'contact',
            "class" => TypeContact::class,
            "data" => [
                "phone" => "test",
                "description" => "test",
                "userID" => $this->getEntityId(User::class),
                "typeContactId" => $this->getEntityId(TypeContact::class)
            ],
            "edit-data" => ["phone" => "test2"]
        ]];
        yield [[
            "path" => 'course',
            "class" => Course::class,
            "data" => [
                "title" => "test",
                "description" => "test",
                "publishDate" => "2021-10-31T08:44:40+00:00",
                "lastEditDate" => "2021-10-31T08:44:40+00:00",
                "image" => "test",
                "isPublic" => true,
                "speakerId" => $this->getEntityId(Speaker::class)
            ],
            "edit-data" => ["phone" => "title"]
        ]];
        yield [[
            "path" => 'course-category',
            "class" => CourseCategory::class,
            "data" => [
                "name" => "test",
                "color" => "#058762",
            ],
            "edit-data" => ["color" => "#ffffff"]
        ]];
        yield [[
            "path" => 'course-part',
            "class" => CoursePart::class,
            "data" => [
                "title" => "title",
                "orderPart" => 1,
                "estimatedTime" => 20,
                "courseSectionId" => $this->getEntityId(CourseSection::class),
            ],
            "edit-data" => ["orderPart" => 2]
        ]];
        yield [[
            "path" => 'course-part-document',
            "class" => CoursePartDocument::class
        ]];
        yield [[
            "path" => 'course-part-quiz',
            "class" => CoursePartQuiz::class
        ]];
        yield [[
            "path" => 'course-section',
            "class" => CourseSection::class,
            "data" => [
                "name" => "test",
                "courseOrder" => 1,
                "courseId" => $this->getEntityId(Course::class),
            ],
            "edit-data" => ["courseOrder" => 2]
        ]];
        yield [[
            "path" => 'favorite-course',
            "class" => FavoriteCourse::class,
            "data" => [
                "courseId" => $this->getEntityId(Course::class),
                "userId" => $this->getEntityId(User::class),
                "addDate" => "2021-10-31T08:44:40+00:00",
            ],
            "edit-data" => ["addDate" => "2020-10-31T08:44:40+00:00"]
        ]];
        yield [[
            "path" => 'group',
            "class" => Group::class,
            "data" => [
                "name" => "test",
                "studentId" => [$this->getEntityId(Student::class)],
                "courseId" => $this->getEntityId(Course::class),
            ],
            "edit-data" => ["name" => "test2"]
        ]];
        yield [[
            "path" => 'notification',
            "class" => Notification::class,
            "data" => [
                "title" => "test",
                "description" => "test",
                "interaction" => '[{"type":"link","value":"https://www.google.com/"}]',
            ],
            "edit-data" => ["title" => "test2"]
        ]];
        yield [[
            "path" => 'quiz',
            "class" => Quiz::class,
            "data" => [
                "title" => "test",
                "theme" => "test",
                "description" => "test",
                "public" => true,
                "timeToPerformAll" => 245,
                "speakerId" => $this->getEntityId(Speaker::class),
            ],
            "edit-data" => ["title" => "test2"]
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
            ],
            "edit-data" => ["question" => "test2"]
        ]];
        yield [[
            "path" => 'quiz-part-perform',
            "class" => QuizPartPerform::class,
            "data" => [
                "timeToResponse" => 245,
                "score" => 1,
                "userId" => $this->getEntityId(User::class),
                "quizPartId" => $this->getEntityId(QuizPart::class),
            ],
            "edit-data" => ["timeToResponse" => 456]
        ]];
        yield [[
            "path" => 'read-later',
            "class" => ReadLater::class,
            "data" => [
                "positionOrder" => 1,
                "userId" => $this->getEntityId(User::class),
                "courseId" => $this->getEntityId(Course::class),
            ],
            "edit-data" => ["positionOrder" => 2]
        ]];
        yield [[
            "path" => 'received-notification',
            "class" => ReceivedNotification::class,
            "data" => [
                "notificationId" => $this->getEntityId(Notification::class),
                "userId" => $this->getEntityId(User::class),
                "viewed" => true,
            ],
            "edit-data" => ["viewed" => false]
        ]];
        yield [[
            "path" => 'skill',
            "class" => Skill::class,
            "data" => [
                "name" => "test",
                "description" => "test",
                "xpRequiredForLevels" => "[{1:2},{2:5},{3:15},{4:50},{5:100}]",
            ],
            "edit-data" => ["name" => "test2"]
        ]];
        yield [[
            "path" => 'skill-user-xp',
            "class" => SkillUserXP::class,
            "data" => [
                "skillId" => $this->getEntityId(Skill::class),
                "userId" => $this->getEntityId(User::class),
                "xp" => 5,
            ],
            "edit-data" => ["xp" => 87]
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
            ],
            "edit-data" => ["name" => "test2"]
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
            ],
            "edit-data" => ["name" => "test2"]
        ]];
        yield [[
            "path" => 'user',
            "class" => User::class
        ]];
    }
    protected function getEntityId($class)
    {
        return $this->getContainer()->get('doctrine')->getRepository($class)->findAll()[0]->getId();
    }

    /**
     * @dataProvider provideUrls
     */
    public function testCrud($data)
    {
        // get all
        $this->client->request('GET', "https://localhost:8000/api/" . $data["path"] . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));

        // get all with page

        $this->client->request('GET', "https://localhost:8000/api/" . $data["path"] . "/2/1", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));

        // get by id
        $this->client->request('GET', "https://localhost:8000/api/" . $data["path"] . "/" . $this->getEntityId($data["class"]), [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));

        // post
        if (!isset($data["data"])) return;

        $this->client->request('POST', "http://localhost:8000/api/" . $data["path"] . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ], json_encode($data["data"]));

        $newEntity = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertIsInt($newEntity["id"]);
        $id = $newEntity["id"];

        // patch
        if (!isset($data["edit-data"])) return;

        $this->client->request('PATCH', "http://localhost:8000/api/" . $data["path"] . "/$id", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ], json_encode($data["edit-data"]));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // delete

        $this->client->request('DELETE', "http://localhost:8000/api/" . $data["path"] . "/$id", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token
        ]);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
