<?php

namespace App\Tests\Unit\Repository;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase {
    /**
     * @dataProvider userRoleProvider
     */
    public function testService($role) {
        $kernel = self::bootKernel();
        //$service = new Service($kernel->getContainer()->get('doctrine'));
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(User::class);
        $service = $kernel->getContainer()->get(UserService::class);
        
        $service->createUser([
            "email"=>"test@test.fr",
            "roles"=>[$role],
            "password"=>"passwordsuperbienhash",
            "firstname"=>"test",
            "name"=>"lenamemegauniq354354",
            "image"=>"https://picsum.photos/1000/700"
        ]);
        $user = $repository->findBy(['name' => 'lenamemegauniq354354'])[0];
        $this->assertEquals('lenamemegauniq354354', $user->getName());
        $service->editUser($user, [
            "email"=>"test@test.fr",
            "roles"=>[$role],
            "name"=>"lenamemegauniq987987978",
            "firstname"=>"test",
            "image"=>"https://picsum.photos/1000/700"
        ]);
        $user = $repository->findBy(['name' => 'lenamemegauniq987987978'])[0];
        $this->assertEquals('lenamemegauniq987987978', $user->getName());
        $service->deleteUser($user);
        $user = $repository->findBy(['name' => 'lenamemegauniq987987978']);
        $this->assertEmpty($user);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testUserServiceException($array){
        $kernel = self::bootKernel();
        $service = $kernel->getContainer()->get(UserService::class);

        $this->expectException(\Exception::class);
        $service->deleteUser(($service->createUser($array)));
        
    }

    public function exceptionProvider() {
        yield [[]];
        yield [[
            "email"=>"test@test.fr"
        ]];
        yield [[
            "email"=>"test@test.fr",
            "roles"=>["ROLE_STUDENT"]
        ]];
        yield [[
            "email"=>"test@test.fr",
            "roles"=>["ROLE_STUDENT"],
            "password"=>"passwordsuperbienhash"
        ]];
        yield [[
            "email"=>"test@test.fr",
            "roles"=>["ROLE_STUDENT"],
            "password"=>"passwordsuperbienhash",
            "firstname"=>"test"
        ]];
        yield [[
            "email"=>"test@test.fr",
            "password"=>"passwordsuperbienhash",
            "name"=>"lenamemegauniq987987978",
            "firstname"=>"test"
        ]];
    }

    public function userRoleProvider() {
        yield ["ROLE_STUDENT"];
        yield ["ROLE_SPEAKER"];
    }
}
