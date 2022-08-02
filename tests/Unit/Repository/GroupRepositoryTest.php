<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GroupRepositoryTest extends KernelTestCase {


    public function testGroupRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $groupRepository = $em->getRepository(Group::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}