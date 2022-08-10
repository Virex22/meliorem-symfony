<?php
namespace App\Service;

use App\Entity\CoursePartDocument;

class CoursePartDocumentService extends AbstractEntityService
{
    protected function getEntityClass() : string
    {
        return CoursePartDocument::class;
    }

    public function create(Array $data) : CoursePartDocument
    {
        $this->validateRequiredData($data, 'linkVideo', 'content','files','coursePartId');
        $coursePartDocument = $this->createEntity($data, 'linkVideo', 'content','files','coursePartId');
        
        return $coursePartDocument;
    }


    public function edit(object $coursePartDocument ,Array $data) : CoursePartDocument
    {
        $this->editEntity($coursePartDocument, $data, 'linkVideo', 'content','files','coursePartId');
        
        return $coursePartDocument;
    }
}