<?php

namespace App\Tests\Unit\Repository;

use App\Entity\SkillUserXP;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillUserXPRepositoryTest extends KernelTestCase {


    public function testSkillUserXPRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $skillUserXPRepository = $em->getRepository(SkillUserXP::class);
        
        $skillUserXP = new SkillUserXP();
        $skillUserXP->setXp(500);
        
        $skillUserXPRepository->add($skillUserXP,true);
        $newSkillUserXP = $skillUserXPRepository->findBy(['xp' => 500])[0];
        $this->assertEquals(500,$newSkillUserXP->getXp());
        $skillUserXPRepository->remove($skillUserXP,true);
        $newSkillUserXP = $skillUserXPRepository->findBy(['xp' => 500]);
        $this->assertEmpty($newSkillUserXP);

    }

}