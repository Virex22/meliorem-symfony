<?php
namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizPart;
use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;

class QuizPartService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    function createQuizPart(Array $quizPart) : QuizPart
    {

        if (!isset($quizPart['question']))
            throw new \Exception('"question" is required');
        if (!isset($quizPart['choice']))
            throw new \Exception('"choice" is required');
        if (!isset($quizPart['answer']))
            throw new \Exception('"answer" is required');
        if (!isset($quizPart['timeMaxToResponse']))
            throw new \Exception('"timeMaxToResponse" is required');
        if (!isset($quizPart['quizOrder']))
            throw new \Exception('"quizOrder" is required');
        if (!isset($quizPart['quizId']))
            throw new \Exception('"quizId" is required');
        if (!isset($quizPart['skillId']))
            throw new \Exception('"skillId" is required');

        $quiz = $this->em->getRepository(Quiz::class)->find($quizPart['quizId']);
        $skill = $this->em->getRepository(Skill::class)->find($quizPart['skillId']);
        if (!$quiz)
            throw new \Exception('Quiz not found, check quizId value');
        if (!$skill)
            throw new \Exception('Skill not found , check skillId value');
        
        $quizPartEntity = new QuizPart();
        $quizPartEntity->setQuestion($quizPart['question'])
            ->setChoice($quizPart['choice'])
            ->setAnswer($quizPart['answer'])
            ->setTimeMaxToResponse($quizPart['timeMaxToResponse'])
            ->setQuizOrder($quizPart['quizOrder'])
            ->setQuiz($quiz)
            ->setSkill($skill);
        $this->em->persist($quizPartEntity);
        $this->em->flush();

        return $quizPartEntity;
    }

    function updateQuizPart(QuizPart $quizPart, Array $data) {
        if (isset($data['question']))
            $quizPart->setQuestion($data['question']);
        if (isset($data['choice']))
            $quizPart->setChoice($data['choice']);
        if (isset($data['answer']))
            $quizPart->setAnswer($data['answer']);
        if (isset($data['timeMaxToResponse']))
            $quizPart->setTimeMaxToResponse($data['timeMaxToResponse']);
        if (isset($data['quizOrder']))
            $quizPart->setQuizOrder($data['quizOrder']);
        if (isset($data['quizId'])){
            $quiz = $this->em->getRepository(Quiz::class)->find($data['quizId']);
            if (!$quiz)
                throw new \Exception('Quiz not found, check quizId value');
            $quizPart->setQuiz($quiz);
        }
        if (isset($data['skillId'])){
            $skill = $this->em->getRepository(Skill::class)->find($data['skillId']);
            if (!$skill)
                throw new \Exception('Skill not found , check skillId value');
            $quizPart->setSkill($skill);
        }
        $this->em->persist($quizPart);
        $this->em->flush();
        return $quizPart;
    }
}
?>