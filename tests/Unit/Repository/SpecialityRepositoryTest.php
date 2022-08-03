<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Speciality;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialityRepositoryTest extends KernelTestCase {


    public function testSpecialityRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $specialityRepository = $em->getRepository(Speciality::class);
        $date = new \DateTime();
        
        $speciality = new Speciality();
        $speciality->setName('Speciality 1 de test')
        ->setBeginAt($date);

        $specialityRepository->add($speciality,true);
        $newSpeciality = $specialityRepository->findBy(['beginAt' => $date])[0];
        $this->assertEquals($date, $newSpeciality->getBeginAt());
        $specialityRepository->remove($speciality,true);
        $newSpeciality = $specialityRepository->findBy(['beginAt' => $date]);
        $this->assertEmpty($newSpeciality);


    }

}