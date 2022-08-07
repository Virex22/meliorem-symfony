<?php
namespace App\Service;

use App\Entity\Skill;
use Doctrine\ORM\EntityManagerInterface;

class SkillService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Skill::class;
    }

    public function create(array $data) : Skill
    {
        
        $this->validateRequiredData($data, 'name', 'description', 'xpRequiredForLevels');
        $skill = $this->createEntity($data, 'name', 'description', 'xpRequiredForLevels');
       
        return $skill;
    }
    public function edit($skill ,array $data) : Skill
    {
        $this->editEntity($skill, $data, 'name', 'description', 'xpRequiredForLevels');
        
        return $skill;
    }

    
}
?>