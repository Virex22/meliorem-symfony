<?php
namespace App\Service;

use App\Entity\Contact;
use App\Entity\TypeContact;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class OLDContactService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createContact(Array $contact) : Contact
    {
        if (!isset($contact['phone'])) 
            throw new \Exception('Phone is required');
        if (!isset($contact['description']))
            throw new \Exception('Description is required');
        if (!isset($contact['typeContactId']))
            throw new \Exception('TypeContact is required');
        $typeContact = $this->em->getRepository(TypeContact::class)->find($contact['typeContactId']);
        if (!$typeContact)
            throw new \Exception('TypeContact not found');
        if (!isset($contact['userId']))
            throw new \Exception('User is required');
        $user = $this->em->getRepository(User::class)->find($contact['userId']);
        if (!$user)
            throw new \Exception('User not found');
        

        $contact = new Contact();
        $contact->setPhone($contact['name'])
        ->setDescription($contact['description'])
        ->setTypeContact($typeContact);
        $contact->setUser($user);

        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }

    public function editContact($contact ,Array $data) : Contact
    {
        if (isset($data['phone']))
            $contact->setPhone($data['phone']);
        if (isset($data['description']))
            $contact->setDescription($data['description']);
        if (isset($data['typeContactId'])){
            $typeContact = $this->em->getRepository(TypeContact::class)->find($data['typeContactId']);
            if (!$typeContact)
                throw new \Exception('TypeContact not found');
            $contact->setTypeContact($typeContact);
        }
        if (isset($data['userId'])){
            $user = $this->em->getRepository(User::class)->find($data['userId']);
            if (!$user)
                throw new \Exception('User not found');
            $contact->setUser($user);
        }

        $this->em->persist($contact);
        $this->em->flush();
        return $contact;
    }
}
?>