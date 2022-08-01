<?php
namespace App\Service;

use App\Entity\TypeContact;
use Doctrine\ORM\EntityManagerInterface;

class TypeContactService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $typeContact) : TypeContact
    {
        if (!isset($typeContact['name']))
            throw new \Exception('Name is required');

        $typeContact = new TypeContact();
        $typeContact->setName($typeContact['name']);

        $this->em->persist($typeContact);
        $this->em->flush();

        return $typeContact;
    }

    public function update(TypeContact $typeContact, Array $typeContactData) : TypeContact
    {
        if (isset($typeContactData['name']))
            $typeContact->setName($typeContactData['name']);

        $this->em->persist($typeContact);
        $this->em->flush();

        return $typeContact;
    }


}
?>