<?php
namespace App\Service;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;

class QuizService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    function createQuiz(Array $quiz) : Quiz
    {

        if (!isset($quiz['description']))
            throw new \Exception('"description" is required');
        if (!isset($quiz['public']))
            throw new \Exception('"public" is required');
        if (!isset($quiz['timeToPerformAll']))
            throw new \Exception('"timeToPerformAll" is required');

        $quiz = new Quiz();
        $quiz->setDescription($quiz['description'])
        ->setPublic($quiz['public'])
        ->setTimeToPerformAll($quiz['timeToPerformAll'])
        ->setCreatedAt(new \DateTime());

        $this->em->persist($quiz);
        $this->em->flush();

        return $quiz;
    }
    
    
}
?>