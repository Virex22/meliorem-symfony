<?php

namespace App\tests\Application\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class testRouteTest extends WebTestCase
{
    

    public function testPing()
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('GET', 'http://localhost:8000/api/test/ping');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    

    public function testPingLogin()
    {
        $client = static::createClient();
        $client->request('POST', 'https://localhost:8000/api/login', array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        '{"username":"superadmin0@meliorem.fr","password":"azerty"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());// recois 500 au lieu de 200
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEquals($data["token"], null);
        
        $client->request('GET', 'http://localhost:8000/api/test/loginping', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '.$data["token"]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
