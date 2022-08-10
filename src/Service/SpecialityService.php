<?php
namespace App\Service;

use App\Entity\Speciality;

class SpecialityService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Speciality::class;
    }

    public function create(Array $data) : Speciality
    {
        $this->validateRequiredData($data, 'speakerId','name');
        if (!isset($data['beginAt'])) 
            $data['beginAt'] = new \DateTime();
        $speciality = $this->createEntity($data, 'speakerId', 'beginAt','name');
    
        return $speciality;
    }


    public function edit(object $speciality ,Array $data) : Speciality
    {
        $this->editEntity($speciality, $data, 'speakerId', 'beginAt','name');
        
        return $speciality;
    }
}