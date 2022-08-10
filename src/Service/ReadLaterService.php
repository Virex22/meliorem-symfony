<?php
namespace App\Service;

use App\Entity\ReadLater;
use DateTime;

class ReadLaterService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return ReadLater::class;
    }

    public function create(Array $data) : ReadLater
    {
        $this->validateRequiredData($data, 'positionOrder', 'userId','courseId');
        if (!isset($data['addDate']))
            $data['addDate'] = new DateTime();
        $readLater = $this->createEntity($data, 'addDate','positionOrder', 'userId','courseId');
        
        return $readLater;
    }


    public function edit(object $readLater ,Array $data) : ReadLater
    {
        $this->editEntity($readLater, $data, 'addDate','positionOrder', 'userId','courseId');
        
        return $readLater;
    }
}