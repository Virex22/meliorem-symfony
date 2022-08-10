<?php
namespace App\Service;

use App\Entity\Group;

class GroupService extends AbstractEntityService
{
    use DeleteTrait;
    
    protected function getEntityClass() : string
    {
        return Group::class;
    }

    public function create(Array $data) : Group
    {
        $this->validateRequiredData($data, 'name');
        $group = $this->createEntity($data, 'name', 'studentId','coursesId');
    
        return $group;
    }


    public function edit(object $group ,Array $data) : Group
    {
        $this->editEntity($group, $data, 'name', 'studentId','coursesId');
        
        return $group;
    }
}