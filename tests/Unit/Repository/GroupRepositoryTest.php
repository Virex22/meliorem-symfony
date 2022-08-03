<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GroupRepositoryTest extends KernelTestCase {


    public function testGroupRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $groupRepository = $em->getRepository(Group::class);
        
        $group = new Group();
        $group->setName('Group 1 de test');

        $groupRepository->add($group,true);
        $newGroup = $groupRepository->findBy(['name' => 'Group 1 de test'])[0];
        $groupRepository->remove($group,true);
        $newGroup = $groupRepository->findBy(['name' => 'Group 1 de test']);
        $this->assertEmpty($newGroup);
        


    }

}