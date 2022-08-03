<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase {


    public function testUserRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $userRepository = $em->getRepository(User::class);


        $user = new User();
        $user->setEmail("test@meliorem.fr")
            ->setPassword("test")
            ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
            ->setName("test")
            ->setFirstName("test")
            ->setImage("test");
        $userRepository->add($user,true);

        $newUser = $userRepository->findBy(['email' => "test@meliorem.fr"])[0];
        $this->assertEquals($newUser->getEmail(), "test@meliorem.fr");
        $userRepository->remove($user,true);
        $newUser = $userRepository->findBy(['email' => "test@meliorem.fr"]);
        $this->assertEmpty($newUser);
        

    }


}