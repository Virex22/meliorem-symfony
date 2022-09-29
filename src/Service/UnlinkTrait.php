<?php

namespace App\Service;

use Countable;
use Doctrine\ORM\EntityManagerInterface;

/**
 * TODO : filtrate the relation entity for dependency deleting
 */

trait UnlinkTrait
{
    private function findPlurialsMethodName(string $methodName, object $entity): string
    {
        $allGetMethod = array_filter(get_class_methods($entity), function ($method) {
            return strpos($method, 'get') === 0;
        });
        $plurials = array_filter($allGetMethod, function ($method) use ($methodName) {
            return strpos($method, substr($methodName, -2)) !== false;
        });
        return reset($plurials);
    }

    public function delete(object $entity, EntityManagerInterface $entityManager)
    {
        $removeMethods = array_filter(get_class_methods($entity), function ($method) {
            return strpos($method, 'remove') === 0;
        });
        if (count($removeMethods) == 0) {
            $entityManager->remove($entity);
            $entityManager->flush();
            return;
        }
        foreach ($removeMethods as $removeMethod) {
            $attribute = substr($removeMethod, 6);
            $getMethod = 'get' . $attribute;
            $getMethod = $this->findPlurialsMethodName($getMethod, $entity);
            $relationnal = $entity->$getMethod();
            if (!$relationnal instanceof Countable || count($relationnal) == 0) continue;
            foreach ($relationnal as $relation)
                $entity->$removeMethod($relation);
        }
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
