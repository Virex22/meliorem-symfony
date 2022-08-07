<?php

namespace App\tests\Application\API;

use App\Entity\MyEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class MyEntityControllerTest extends WebTestCase
{
    private $client;
    private $token;

    public function setUp() : void
    {
        $this->client = HttpClient::create();
        $client = static::createClient();
        $client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"superadmin0@meliorem.fr","password":"azerty"}');

        $this->token = json_decode($client->getResponse()->getContent(), true)["token"];
    }
    

    public function testGetAllAndGetById()
    {
        $this->client->request('GET', `http://localhost:8000/api/myentity/`, [], [], [
            'HTTP_AUTHORIZATION' => `Bearer $this->token`
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $myEntity = json_decode($this->client->getResponse()->getContent(), true)[0];
        $id = json_decode($this->client->getResponse()->getContent(), true)[0]["id"];
        $this->client->request('GET', `http://localhost:8000/api/myentity/${$id}`, [], [], [
            'HTTP_AUTHORIZATION' => `Bearer $this->token`
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($myEntity["cle"], json_decode($this->client->getResponse()->getContent(), true)["cle"]);
    }
    public function testPostPatchAndDelete()
    {
        
    }
    
}
