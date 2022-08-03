<?php

namespace App\Tests\Unit\Repository;

use App\Entity\MyEntity;
use App\Service\MyEntityService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MyEntityServiceTest extends KernelTestCase {

    public function testService() {
        $kernel = self::bootKernel();
        //$service = new Service($kernel->getContainer()->get('doctrine'));
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(MyEntity::class);
        $service = $kernel->getContainer()->get(MyEntityService::class);
        
        $service->create([
            'cle' => 'maValeursDeBase'
        ]);
        $myEntity = $repository->findBy(['cle' => 'maValeursDeBase'])[0];
        $this->assertEquals('maValeursDeBase', $myEntity->getCle());
        $service->update($myEntity, [
            'cle' => 'maValeursModifier'
        ]);
        $myEntity = $repository->findBy(['cle' => 'maValeursModifier'])[0];
        $this->assertEquals('maValeursModifier', $myEntity->getCle());
        $repository->remove($myEntity,true);
        $myEntity = $repository->findBy(['cle' => 'maValeursModifier']);
        $this->assertEmpty($myEntity);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testMyEntityServiceException($array){
        $kernel = self::bootKernel();
        $service = $kernel->getContainer()->get(MyEntityService::class);

        $this->expectException(\Exception::class);
        $service->create($array);
    }

    public function exceptionProvider() {
        yield [[]];
    }
}
