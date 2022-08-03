<?php

namespace App\Tests\Unit\Repository;

use App\Entity\FavoriteCourse;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FavoriteCourseRepositoryTest extends KernelTestCase {


    public function testFavoriteCourseRepository() {
        $kernel = self::bootKernel();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $favoriteCourseRepository = $em->getRepository(FavoriteCourse::class);
        $userRepository = $em->getRepository(User::class);
        $user = new User();
        $user->setEmail("test@meliorem.frfavorite")
            ->setPassword("test")
            ->setRoles(["ROLE_USER", "ROLE_SUPERADMIN"])
            ->setName("test")
            ->setFirstName("test")
            ->setImage("test");
        $date = new \DateTime();
        $userRepository->add($user,true);
        $newUser = $userRepository->findBy(['email' => "test@meliorem.frfavorite"])[0];
        $favoriteCourse = new FavoriteCourse();
        $favoriteCourse->setUser($newUser)
        ->setAddDate($date);
        $favoriteCourseRepository->add($favoriteCourse,true);
        $newFavoriteCourse = $favoriteCourseRepository->findBy(['user' => $newUser])[0];
        $this->assertEquals($newFavoriteCourse->getUser(), $newUser);
        $favoriteCourseRepository->remove($favoriteCourse,true);
        $userRepository->remove($newUser,true);
        $newFavoriteCourse = $favoriteCourseRepository->findBy(['user' => $newUser]);
        $this->assertEmpty($newFavoriteCourse);

    }

}