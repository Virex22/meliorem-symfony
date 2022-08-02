<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Badge;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BadgeRepositoryTest extends KernelTestCase {


    public function testBadgeRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $badgeRepository = $em->getRepository(Badge::class);
        $this->assertNotSame("TODO","implement more than constructor");
    }

}