<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Skill;
use App\Service\SkillService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SkillServiceTest extends KernelTestCase {

    public function testService() {
        $kernel = self::bootKernel();
        //$service = new Service($kernel->getContainer()->get('doctrine'));
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(Skill::class);
        $service = $kernel->getContainer()->get(SkillService::class);
        
        $service->create([
            'name' => 'maValeursDeBase',
            'description' => 'maValeursDeBase',
            'xpRequiredForLevels' => 'maValeursDeBase'
        ]);
        $skill = $repository->findBy(['name' => 'maValeursDeBase'])[0];
        $this->assertEquals('maValeursDeBase', $skill->getName());
        $service->edit($skill, [
            'name' => 'maValeursModifier',
            'description' => 'maValeursDeBase',
            'xpRequiredForLevels' => 'maValeursDeBase'
        ]);
        $skill = $repository->findBy(['name' => 'maValeursModifier'])[0];
        $this->assertEquals('maValeursModifier', $skill->getName());
        $repository->remove($skill,true);
        $skill = $repository->findBy(['name' => 'maValeursModifier']);
        $this->assertEmpty($skill);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testSkillServiceException($array){
        $kernel = self::bootKernel();
        $service = $kernel->getContainer()->get(SkillService::class);

        $this->expectException(\Exception::class);
        $service->create($array);
    }

    public function exceptionProvider() {
        yield [[]];
        yield [[
            'name' => 'maValeursDeBase',
            'xpRequiredForLevels' => 'maValeursDeBase'
        ]];
        yield [[
            'name' => 'maValeursDeBase',
            'description' => 'maValeursDeBase',
        ]];
    }
}
