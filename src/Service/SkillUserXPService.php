<?php
namespace App\Service;

use App\Entity\SkillUserXP;

class SkillUserXPService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return SkillUserXP::class;
    }

    public function create(Array $data) : SkillUserXP
    {
        $this->validateRequiredData($data, 'skillId','userId');
        if (!isset($data['xp']))
            $data['xp'] = 0;
        $skillUserXP = $this->createEntity($data, 'xp', 'skillId','userId');
    
        return $skillUserXP;
    }


    public function edit(object $skillUserXP ,Array $data) : SkillUserXP
    {
        $this->editEntity($skillUserXP, $data,  'xp', 'skillId','userId');
        
        return $skillUserXP;
    }
}