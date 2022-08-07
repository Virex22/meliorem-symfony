<?php
namespace App\Service;

use App\Entity\Contact;

class ContactService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Contact::class;
    }

    public function create(Array $data) : Contact
    {
        $this->validateRequiredData($data, 'phone', 'description');
        $contact = $this->createEntity($data, 'phone', 'description', 'typeContactId', 'userId');
        
        return $contact;
    }


    public function edit($contact ,Array $data) : Contact
    {
        $this->editEntity($contact, $data, 'phone', 'description', 'typeContactId', 'userId');
        
        return $contact;
    }
}
?>