<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillRepositoryTest extends KernelTestCase {


    public function testSkillRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $skillRepository = $em->getRepository(Skill::class);
        
        $skill = new Skill();
        $skill->setName('Skill 1 test for test')
        ->setDescription('Description de Skill 1')
        ->setXpRequiredForLevels('[1,2,3,4,5,6,7,8,9,10]');

        $skillRepository->add($skill,true);
        $newSkill = $skillRepository->findBy(['name' => 'Skill 1 test for test'])[0];
        $skillRepository->remove($newSkill,true);
        $newSkill = $skillRepository->findBy(['name' => 'Skill 1 test for test']);
        $this->assertEmpty($newSkill);

    }

}