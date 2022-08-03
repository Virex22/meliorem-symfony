<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Badge;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BadgeRepositoryTest extends KernelTestCase {


    public function testBadgeRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $badgeRepository = $em->getRepository(Badge::class);
        
        $badge = new Badge();
        $badge->setName('Badge 1')
            ->setImage('badge1.png')
            ->setDescription('Badge 1 description');

        $badgeRepository->add($badge,true);
        $newBadge = $badgeRepository->findBy(['name' => 'Badge 1'])[0];
        $this->assertEquals('Badge 1', $newBadge->getName());
        $badgeRepository->remove($badge,true);
        $newBadge = $badgeRepository->findBy(['name' => 'Badge 1']);
        $this->assertEmpty($newBadge);
    }

}