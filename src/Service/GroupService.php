<?php
namespace App\Service;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class GroupService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Array $data) : Group
    {
        if (!isset($data['name']))
            throw new \Exception('"name" is required');
        

        $group = new Group();
        $group->setName($data['name']);

        $this->em->persist($group);
        $this->em->flush();
       
        return $group;
    }


    public function update(Group $group, Array $groupData) : Group
    {
        if (isset($groupData['name']))
            $group->setName($groupData['name']);
        
        $this->em->persist($group);
        $this->em->flush();

        return $group;
    }
}
?>