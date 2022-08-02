<?php

namespace App\Tests\Unit\Repository;

use App\Entity\FavoriteCourse;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FavoriteCourseRepositoryTest extends KernelTestCase {


    public function testFavoriteCourseRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $favoriteCourseRepository = $em->getRepository(FavoriteCourse::class);
        $this->assertNotSame("TODO","implement more than constructor");

    }

}