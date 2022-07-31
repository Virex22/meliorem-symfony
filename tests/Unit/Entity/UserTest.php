<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTest extends KernelTestCase
{

    public function testUserConstructorGetterAndSetter() {
        $user = new User();
        $user->setEmail("test@meliorem.fr")
        ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
        ->setFirstname("test")
        ->setName("test")
        ->setImage("https://test")
        ->setPassword("hash");
        $this->assertEquals("test@meliorem.fr", $user->getEmail());
        $this->assertEquals(["ROLE_USER", "ROLE_SUPERADMIN"], $user->getRoles());
        $this->assertEquals("test", $user->getFirstname());
        $this->assertEquals("test", $user->getName());
        $this->assertEquals("https://test", $user->getImage());
        $this->assertEquals("hash", $user->getPassword());
        $this->assertNull($user->getId());
    }

}