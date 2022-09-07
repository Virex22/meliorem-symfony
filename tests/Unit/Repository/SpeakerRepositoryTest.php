<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Speaker;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpeakerRepositoryTest extends KernelTestCase {


    public function testSpeakerRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $speakerRepository = $em->getRepository(Speaker::class);
        $userRepository = $em->getRepository(User::class);
        
        $user = new User();
        $user->setEmail("speaker@meliorem.fr")
            ->setPassword("test")
            ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
            ->setName("test")
            ->setFirstName("test")
            ->setImage("test")
            ->setActivated(true)
            ->setCreatedAt(new \DateTime());
        $userRepository->add($user,true);

        $speaker = new Speaker();
        $speaker->setUser($user);
        
        $speakerRepository->add($speaker,true);
        $newSpeaker = $speakerRepository->findBy(['user' => $user])[0];
        $this->assertEquals($newSpeaker->getUser(), $user);
        $speakerRepository->remove($speaker,true);
        $userRepository->remove($user,true);
        $newSpeaker = $speakerRepository->findBy(['user' => $user]);
        $this->assertEmpty($newSpeaker);


    }

}