<?php

namespace App\tests\Application\API;

use App\Entity\TypeContact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class TypeContactControllerTest extends WebTestCase
{
    private $token;

    public function setUp() : void
    {
        $client = static::createClient();
        $client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"superadmin0@meliorem.fr","password":"azerty"}');

        $this->token = json_decode($client->getResponse()->getContent(), true)["token"];
        
    }
    

    public function testGetAllAndGetById()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('GET', "http://localhost:8000/api/type-contact/", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $typeContact = json_decode($client->getResponse()->getContent(), true)[0];
        $id = json_decode($client->getResponse()->getContent(), true)[0]["id"];
        $client->request('GET', "http://localhost:8000/api/type-contact/$id", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($typeContact["name"], json_decode($client->getResponse()->getContent(), true)["name"]);

        // unknow id
        $id = -1;
        $client->request('GET', "http://localhost:8000/api/type-contact/$id", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ]);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
    public function testPostPatchAndDelete()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('POST', "http://localhost:8000/api/type-contact/", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ], '{"name":"testApplication : post"}');
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $id = json_decode($client->getResponse()->getContent(), true)["id"];
        $client->request('PATCH', "http://localhost:8000/api/type-contact/$id", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ], '{"name":"testApplication : patch"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals("testApplication : patch", json_decode($client->getResponse()->getContent(), true)["name"]);
        $client->request('DELETE', "http://localhost:8000/api/type-contact/$id", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $this->token"
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testPostPatchAndDeleteUnauthorized()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"student0@meliorem.fr","password":"azerty"}');

        $token = json_decode($client->getResponse()->getContent(), true)["token"];

        $client->request('POST', "http://localhost:8000/api/type-contact/", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ], '{"name":"testApplication : post"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        $client->request('PATCH', "http://localhost:8000/api/type-contact/2", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ], '{"name":"testApplication : patch"}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        $client->request('DELETE', "http://localhost:8000/api/type-contact/2", [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ]);
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
    
}
