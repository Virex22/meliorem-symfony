<?php 
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


trait DeleteTrait
{
    use UnlinkTrait{
        UnlinkTrait::delete as unlink;
    }
    
    public function delete(object $entity,EntityManagerInterface $entityManager){
        $attributes = $this->getDeleteAttributes();
        foreach($attributes as $attribute){
            // remove or set methode
            $deleteMethod = 'remove'. ucfirst($attribute);
            if(!method_exists($entity,$deleteMethod)){
                $deleteMethod = 'set'. ucfirst($attribute);
                if(!method_exists($entity,$deleteMethod)) throw new \Exception('No remove or set method for '.$attribute);
            }
            
            // get methode
            $getMethod = '';
            if (!method_exists($entity,'get'. ucfirst($attribute)))
            $getMethod = 'get'. ucfirst($attribute);
            else if (!method_exists($entity,'is'. ucfirst($attribute)))
            $getMethod = 'is'. ucfirst($attribute);
            else throw new \Exception('No get method for '.$attribute);
            
            // remove or set to remove reference
            $relationnal = $entity->$getMethod();
            if (is_array($relationnal))
            foreach($relationnal as $relation)
            $entity->$deleteMethod($relation);
            else{
                $entity->$deleteMethod(null);
            }
            
            $this->unlink($entity,$entityManager);
        }
    }


    /**
     * @exemple : return ['quizParts','speaker'];
     */
    abstract public function getDeleteAttributes() : array;
}
