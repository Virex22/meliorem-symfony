<?php

namespace App\Tests\Unit\Repository;

use App\Entity\TypeContact;
use App\Service\TypeContactService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TypeContactServiceTest extends KernelTestCase {

    public function testTypeContactService() {
        $kernel = self::bootKernel();
        //$typeContactService = new TypeContactService($kernel->getContainer()->get('doctrine'));
        $typeContactRepository = $kernel->getContainer()->get('doctrine')->getRepository(TypeContact::class);
        $typeContactService = $kernel->getContainer()->get(TypeContactService::class);
        
        $typeContactService->create([
            'name' => 'TypeContactservicetest 1'
        ]);
        $newTypeContact = $typeContactRepository->findBy(['name' => 'TypeContactservicetest 1'])[0];
        $this->assertEquals('TypeContactservicetest 1', $newTypeContact->getName());
        $typeContactService->edit($newTypeContact, [
            'name' => 'TypeContactservicetest 2'
        ]);
        $newTypeContact = $typeContactRepository->findBy(['name' => 'TypeContactservicetest 2'])[0];
        $this->assertEquals('TypeContactservicetest 2', $newTypeContact->getName());
        $typeContactRepository->remove($newTypeContact,true);
        $newTypeContact = $typeContactRepository->findBy(['name' => 'TypeContactservicetest 2']);
        $this->assertEmpty($newTypeContact);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testTypeContactServiceException($array){
        $kernel = self::bootKernel();
        $typeContactService = $kernel->getContainer()->get(TypeContactService::class);

        $this->expectException(\Exception::class);
        $typeContactService->create($array);
    }

    public function exceptionProvider() {
        yield [[]];
    }
}
