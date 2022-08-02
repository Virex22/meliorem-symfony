<?php

namespace App\Tests\Unit\Repository;

use App\Entity\SkillUserXP;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillUserXPRepositoryTest extends KernelTestCase {


    public function testSkillUserXPRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $skillUserXPRepository = $em->getRepository(SkillUserXP::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}