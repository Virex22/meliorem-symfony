<?php 
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


/**
 * TODO : filtrate the relation entity for dependency deleting
 */


trait DeleteTrait
{
    use UnlinkTrait{
        UnlinkTrait::delete as unlink;
    }
    
    public function delete(object $entity,EntityManagerInterface $entityManager){
        $this->unlink($entity,$entityManager);
        $attributes = $this->getDeleteEntities();
        foreach($attributes as $attribute){
            $isSetFunction = false;
            $removeMethod = 'remove'. ucfirst($attribute);
            if(!method_exists($entity,$removeMethod)){
                $removeMethod = 'set'. ucfirst($attribute);
                $isSetFunction = true;
                if(!method_exists($entity,$removeMethod))continue;
            }
            if (!method_exists($entity,'get'. ucfirst($attribute)))
                $getMethod = 'get'. ucfirst($attribute);
            else if (!method_exists($entity,'is'. ucfirst($attribute)))
                $getMethod = 'is'. ucfirst($attribute);
            else continue;
            $relationnal = $entity->$getMethod();
            if($isSetFunction){
                $entity->$removeMethod(null);
                continue;
            }
            if(count($relationnal) == 0)continue;
            foreach($relationnal as $relation)
                $entity->$removeMethod($relation);

        }
    }


    /**
     * @exemple : return ['quizParts','speaker'];
     */
    abstract public function getDeleteAttributes() : array;
}
