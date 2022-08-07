<?php
namespace App\Service;

use App\Entity\QuizPartPerform;
use App\Entity\TypeQuizPartPerform;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class QuizPartPerformService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $data) : QuizPartPerform
    {
        if (!isset($data['date']))
            throw new \Exception('"date" is required');
        if (!isset($data['score']))
            throw new \Exception('"score" is required');
        if (!isset($data['timeToResponse']))
            throw new \Exception('"timeToResponse" is required');
        if (!isset($data['userId']))
            throw new \Exception('"userId" is required');
        $user = $this->em->getRepository(User::class)->find($data['userId']);
        if (!$user)
            throw new \Exception('"userId" is invalid');
        if (!isset($data['quizPartId']))
            throw new \Exception('"quizPartId" is required');
        $quizPart = $this->em->getRepository(TypeQuizPartPerform::class)->find($data['quizPartId']);
        if (!$quizPart)
            throw new \Exception('"quizPartId" is invalid');



        $quizpartperform = new QuizPartPerform();
        $quizpartperform->setTimeToResponse($data['timeToResponse'])
            ->setScore($data['score'])
            ->setDate($data['date'])
            ->setUser($user)
            ->setQuizPart($quizPart);

        $this->em->persist($quizpartperform);
        $this->em->flush();

        return $quizpartperform;
    }

    public function update($quizpartperform ,Array $data) : QuizPartPerform
    {
        if (isset($data['date']))
            $quizpartperform->setDate($data['date']);
        if (isset($data['score']))
            $quizpartperform->setScore($data['score']);
        if (isset($data['timeToResponse']))
            $quizpartperform->setTimeToResponse($data['timeToResponse']);
        if (isset($data['userId'])){
            $user = $this->em->getRepository(User::class)->find($data['userId']);
            if (!$user)
                throw new \Exception('"userId" is invalid');
            $quizpartperform->setUser($user);
        }
        if (isset($data['quizPartId'])){
            $quizPart = $this->em->getRepository(TypeQuizPartPerform::class)->find($data['quizPartId']);
            if (!$quizPart)
                throw new \Exception('"quizPartId" is invalid');
            $quizpartperform->setQuizPart($quizPart);
        }

        $this->em->persist($quizpartperform);
        $this->em->flush();
        return $quizpartperform;
    }
}
?>