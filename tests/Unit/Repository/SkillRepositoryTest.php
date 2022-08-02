<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillRepositoryTest extends KernelTestCase {


    public function testSkillRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $skillRepository = $em->getRepository(Skill::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}