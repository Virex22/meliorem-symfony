<?php
namespace App\Service;

use App\Entity\Badge;

class BadgeService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return Badge::class;
    }

    public function create(Array $data) : Badge
    {
        $this->validateRequiredData($data, 'name', 'image','description');
        $badge = $this->createEntity($data, 'name', 'image','description');
        
        return $badge;
    }


    public function edit(object $badge ,Array $data) : Badge
    {
        $this->editEntity($badge, $data, 'name', 'image','description');
        
        return $badge;
    }
}
?>