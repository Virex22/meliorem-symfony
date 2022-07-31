<?php

namespace App\tests\Unit\DTO;

use App\DTO\UserDTO;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserDTOTest extends TestCase
{
    public function testUserDTOConstructorGetterAndSetter()
    {
        $user = new User();
        $user->setEmail("test@meliorem.fr")
        ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
        ->setFirstname("test")
        ->setName("test2")
        ->setImage("https://test")
        ->setPassword("hash");

        $userDTO = new UserDTO();
        $userDTO->hydrate($user);
        $this->assertNotContains("hash", $userDTO->getData());
        $this->assertContains("https://test", $userDTO->getData());
        $this->assertContains(["ROLE_USER", "ROLE_SUPERADMIN"], $userDTO->getData());
        $this->assertContains("test", $userDTO->getData());
        $this->assertContains("test2", $userDTO->getData());
        $this->assertContains(null, $userDTO->getData());
    }
}