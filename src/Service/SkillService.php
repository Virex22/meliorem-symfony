<?php
namespace App\Service;

use App\Entity\Skill;

class SkillService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Skill::class;
    }

    public function create(Array $data) : Skill
    {
        $this->validateRequiredData($data, 'name', 'xpRequiredForLevels','description');
        $skill = $this->createEntity($data, 'name', 'xpRequiredForLevels','description');
        
        return $skill;
    }


    public function edit(object $skill ,Array $data) : Skill
    {
        $this->editEntity($skill, $data, 'name', 'xpRequiredForLevels','description');
        
        return $skill;
    }
}