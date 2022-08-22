<?php

use App\Entity\Course;
use App\Entity\CoursePart;
use App\Entity\CourseSection;
use App\Entity\Quiz;
use App\Entity\Speaker;
use App\Entity\TypeContact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerCreateUpdateDeleteTest extends WebTestCase
{
    private $token;
    private $client;

    public function setUp(): void{
        self::ensureKernelShutdown();
        $this->client = static::createClient();
        $this->client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"superadmin0@meliorem.fr","password":"azerty"}');
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->token = $data["token"];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testCreateUpdateDelete($data){
        $this->client->request('POST', "http://localhost:8000/api/" . $data["path"] . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ],json_encode($data["data"]));
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());

        // $id = json_decode($this->client->getResponse()->getContent(), true)["id"];

        // $this->client->request('PATCH', "http://localhost:8000/api/" . $data["path"] . "/" . $id, [], [], [
        //     'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        // ],json_encode($data["data"]));
        // $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // $this->client->request('DELETE', "http://localhost:8000/api/" . $data["path"] . "/" . $id, [], [], [
        //     'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        // ]);
        // $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }

    protected function getEntityId($class){
        return $this->getContainer()->get('doctrine')->getRepository($class)->findAll()[0]->getId();
    }

    public function provideUrls(){
        yield [["path" => 'badge',
            "data" => [
                "name" => "test",
                "description" => "test",
                "image" => "test",
                "UserId" => $this->getEntityId(User::class)
            ]]];
        yield [["path" => 'contact',
            "data" => [
                "phone" => "test",
                "description" => "test",
                "userID" => $this->getEntityId(User::class),
                "typeContactId" => $this->getEntityId(TypeContact::class)
            ]]];
        yield [["path" => 'course',
            "data" => [
                "title" => "test",
                "description" => "test",
                "publishDate" => "2021-10-31T08:44:40+00:00",
                "lastEditDate" => "2021-10-31T08:44:40+00:00",
                "image" => "test",
                "isPublic" => true,
                "speakerId" => $this->getEntityId(Speaker::class)
            ]]];
        yield [["path" => 'course-category',
            "data" => [
                "name" => "test",
                "color" => "#058762",
            ]]];
        yield [["path" => 'course-part',
            "data" => [
                "title" => "title",
                "orderPart" => 1,
                "estimatedTime" => 20,
                "courseSectionId"=> $this->getEntityId(CourseSection::class),
            ]]];
        yield [["path" => 'course-part-document',
            "data" => [
                "linkVideo" => "title",
                "content" => "description",
                "files" => "files",
                "coursePartId"=> $this->getEntityId(CoursePart::class),
            ]]];
        yield [["path" => 'course-part-quiz',
            "data" => [
                "quizId" => $this->getEntityId(Quiz::class),
                "coursePartId"=> $this->getEntityId(CoursePart::class),
            ]]];
        yield [["path" => 'course-section',
            "data" => [
                "name" => "test",
                "courseOrder" => 1,
                "courseId"=> $this->getEntityId(Course::class),
            ]]];
        // yield [["path" => 'favorite-course',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'group',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'notification',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'quiz',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'quiz-part',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'quiz-part-perform',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'read-later',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'received-notification',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'skill',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'skill-user-xp',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'speciality',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'type-contact',
        //     "data" => [
                
        //     ]]];
        // yield [["path" => 'user',
        //     "data" => [
                
        //     ]]];
    }
}