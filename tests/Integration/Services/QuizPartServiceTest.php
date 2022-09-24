<?php

namespace App\Tests\Unit\Repository;

use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\Skill;
use App\Service\QuizPartService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuizPartServiceTest extends KernelTestCase
{

    public function testService()
    {
        $kernel = self::bootKernel();
        //$service = new Service($kernel->getContainer()->get('doctrine'));
        $repository = $kernel->getContainer()->get('doctrine')->getRepository(QuizPart::class);
        $repositoryQuiz = $kernel->getContainer()->get('doctrine')->getRepository(Quiz::class);
        $repositorySkill = $kernel->getContainer()->get('doctrine')->getRepository(Skill::class);
        $service = $kernel->getContainer()->get(QuizPartService::class);

        $quiz = new Quiz();
        $quiz->setDescription("descriptiontestestest");
        $quiz->setPublic(true)
            ->setCreatedAt(new DateTime())
            ->setTimeToPerformAll(10452540)
            ->setTheme("theme")
            ->setTitle("je suis le numero 3657452");
        $repositoryQuiz->add($quiz, true);
        $quiz = $repositoryQuiz->findBy(['description' => 'descriptiontestestest'])[0];

        $skill = new Skill();
        $skill->setName("skilltestestseteststest")
            ->setDescription("descriptiontestestest")
            ->setXpRequiredForLevels('10,20,30,40,50,60,70,80,90,100');
        $repositorySkill->add($skill, true);
        $skill = $repositorySkill->findBy(['name' => 'skilltestestseteststest'])[0];

        $service->create([
            "question"  => "question35435",
            "choice"  => "choice",
            "answer"  =>  "answer",
            "timeMaxToResponse"  =>  10,
            "quizOrder"  => 1,
            "quizId" => $quiz->getId(),
            "skillId" => $skill->getId()
        ]);
        $quizPart = $repository->findBy(['question' => 'question35435'])[0];
        $this->assertEquals('question35435', $quizPart->getQuestion());
        $service->edit($quizPart, [
            "question"  => "questionedited",
            "choice"  => "choice",
            "answer"  =>  "answer",
            "timeMaxToResponse"  =>  10,
            "quizOrder"  => 1,
            "quizId" => $quiz->getId(),
            "skillId" => $skill->getId()
        ]);
        $quizPart = $repository->findBy(['question' => 'questionedited'])[0];
        $this->assertEquals('questionedited', $quizPart->getQuestion());
        $repository->remove($quizPart, true);
        $quizPart = $repository->findBy(['question' => 'questionedited']);
        $this->assertEmpty($quizPart);

        $repositoryQuiz->remove($quiz, true);
        $repositorySkill->remove($skill, true);
    }

    /**
     * @dataProvider exceptionProvider
     */
    public function testQuizPartServiceException($array)
    {
        $kernel = self::bootKernel();
        $service = $kernel->getContainer()->get(QuizPartService::class);

        $this->expectException(\Exception::class);
        $service->create($array);
    }

    public function exceptionProvider()
    {
        yield [[]];
        yield [[
            "question"  => "question35435",
        ]];
        yield [[
            "question"  => "question35435",
            "choice"  => "choice",
        ]];
        yield [[
            "question"  => "question35435",
            "choice"  => "choice",
            "answer"  =>  "answer",
        ]];
        yield [[
            "question"  => "question35435",
            "choice"  => "choice",
            "answer"  =>  "answer",
            "timeMaxToResponse"  =>  10,
        ]];
    }
}
