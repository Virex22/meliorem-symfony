<?php 

namespace App\tests\Application\API;
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
        yield ['badge'];
        yield ['contact'];
        yield ['course'];
        yield ['course-category'];
        yield ['course-part'];
        yield ['course-part-document'];
        yield ['course-part-quiz'];
        yield ['course-section'];
        yield ['favorite-course'];
        yield ['group'];
        yield ['notification'];
        yield ['quiz'];
        yield ['quiz-part'];
        yield ['quiz-part-perform'];
        yield ['read-later'];
        yield ['received-notification'];
        yield ['skill'];
        yield ['skill-user-xp'];
        yield ['speaker'];
        yield ['speciality'];
        yield ['student'];
        yield ['type-contact'];
        yield ['user'];
    }

    /**
     * @dataProvider provideUrls
     */
    public function testIndex($path){
        $this->client->request('GET', "http://localhost:8000/api/" . $path . "/", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ]);
        file_put_contents("tests/Application/API/debug.html", $this->client->getResponse()->getContent());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));
    }
    /**
     * @dataProvider provideUrls
     */
    public function testShow($path){
        $this->client->request('GET', "http://localhost:8000/api/" . $path . "/123456789", [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '. $this->token
        ]);
        file_put_contents("tests/Application/API/debug.html", $this->client->getResponse()->getContent());
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertIsArray(json_decode($this->client->getResponse()->getContent(), true));
    }

   
}