<?php
namespace App\Service;

use App\Entity\TypeContact;

class TypeContactService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return TypeContact::class;
    }

    public function create(Array $data) : TypeContact
    {
        $this->validateRequiredData($data,'name');
        $typeContact = $this->createEntity($data, 'name');
    
        return $typeContact;
    }


    public function edit(object $typeContact ,Array $data) : TypeContact
    {
        $this->editEntity($typeContact, $data, 'name');
        
        return $typeContact;
    }
}