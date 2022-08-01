<?php
namespace App\Service;

use App\Entity\Speaker;
use App\Entity\Speciality;
use App\Entity\Student;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class SpecialityService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $speciality): Speciality
    {
        if (!isset($speciality['name']))
            throw new \Exception('Name is required');
        if (!isset($speciality['beginAt']))
            throw new \Exception('beginAt is required');
        if (!isset($speciality['speakerId']))
            throw new \Exception('speakerId is required');
        $speaker = $this->em->getRepository(Speaker::class)->find($speciality['speakerId']);
        if (!$speaker)
            throw new \Exception('speakerId is invalid');
        
        $speciality = new Speciality();
        $speciality->setName($speciality['name'])
            ->setBeginAt(new \DateTime($speciality['beginAt']))
            ->setSpeaker($speaker);
        
        $this->em->persist($speciality);
        $this->em->flush();
        
        return $speciality;
    }

    public function edit(Speciality $speciality, Array $data): Speciality
    {
        if (isset($data['name']))
            $speciality->setName($data['name']);
        if (isset($data['beginAt']))
            $speciality->setBeginAt(new \DateTime($data['beginAt']));
        if (isset($data['speakerId'])){
            $speaker = $this->em->getRepository(Speaker::class)->find($data['speakerId']);
            if (!$speaker)
                throw new \Exception('speakerId is invalid');
            $speciality->setSpeaker($speaker);
        }
        $this->em->persist($speciality);
        $this->em->flush();
        return $speciality;
    }


}
?>