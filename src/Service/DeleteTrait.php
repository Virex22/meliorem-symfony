<?php 
namespace App\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;


trait DeleteTrait
{
    use UnlinkTrait{
        UnlinkTrait::delete as unlink;
    }

    /**
     * @return array Collection
     */
    abstract public function getEntitiesArray($id) : array;

    private function deleteRecursive($entities,$entityManager){
        foreach ($entities as $entity) {
            if ($entity instanceof Collection || is_array($entity)) {
                $this->deleteRecursive($entity,$entityManager);
            } else {
                $entityManager->remove($entity);
            }
        }
    }
    
    public function delete(object $entityToDelete,EntityManagerInterface $entityManager){
        $entities = $this->getEntitiesArray($entityToDelete->getId());
        $this->deleteRecursive($entities,$entityManager);
        $entityManager->flush();
        $this->unlink($entityToDelete, $entityManager);
    }
}
