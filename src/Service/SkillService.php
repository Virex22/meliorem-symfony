<?php
namespace App\Service;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;

class SkillService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createSkill(Array $skill) : Skill
    {
        if (!isset($skill['name']))
            throw new \Exception('"name" is required');
        if (!isset($skill['xpRequiredForLevels']))
            throw new \Exception('"xpRequiredForLevels" is required');
        if (!isset($skill['description']))
            throw new \Exception('"description" is required');

        $skill = new Skill();
        $skill->setName($skill['name'])
        ->setXpRequiredForLevels($skill['xpRequiredForLevels'])
        ->setDescription($skill['description']);

        $this->em->persist($skill);
        $this->em->flush();

        return $skill;
    }


    public function updateSkill(Skill $skill, Array $skillData) : Skill
    {
        if (isset($skillData['name']))
            $skill->setName($skillData['name']);
        if (isset($skillData['xpRequiredForLevels']))
            $skill->setXpRequiredForLevels($skillData['xpRequiredForLevels']);
        if (isset($skillData['description']))
            $skill->setDescription($skillData['description']);

        $this->em->persist($skill);
        $this->em->flush();

        return $skill;
    }
}
?>