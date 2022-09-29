<?php
namespace App\Service;

use App\Service\IService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use TypeError;

abstract class AbstractEntityService implements IService
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    abstract protected function getEntityClass() : string;

    abstract public function create(Array $data): object;

    abstract public function edit(object $entity, Array $data): object;

    /**
     * variadic function
     * validate the required data on the service
     * @param array $data
     * @param string checkattribute
     * @return self
     * @example 'default' $this->validateRequiredData($data, 'name', 'description');
     */
    protected function validateRequiredData(Array $data ,string ...$checkAttribute) : self
    {
        foreach ($checkAttribute as $value)
            if (!isset($data[$value]))
                throw new \Exception("'$value' is required");
        return $this;
    }
    /**
     * variadic function
     * @param array $data
     * @param string $attribute
     */
    protected function createEntity(Array $data ,string ...$attributes) : object
    {
        $class = $this->getEntityClass();
        $entity = new $class();
        foreach ($attributes as $attribute)
        {
            if (!isset($data[$attribute])) // for unrequired attribute
                continue;
            if (preg_match('/Id$/', $attribute)){
                $relationnalEntity = $this->createRelation($data[$attribute], ucfirst(substr($attribute, 0, -2)));
                if (is_array($relationnalEntity)){
                    $attribute = $this->repairsTableAttribute(ucfirst(substr($attribute, 0, -2)));
                    foreach ($relationnalEntity as $value){
                        $method = 'add' . $attribute;
                        $entity->$method($value);
                    }
                }
                else
                { 
                    $method = 'set' . ucfirst(substr($attribute, 0, -2));
                    $entity->$method($relationnalEntity);
                }
            }
            else
                {
                    $method = 'set' . ucfirst($attribute);
                    try {
                        $entity->$method($data[$attribute]);
                    } catch (TypeError $e) {
                        $entity->$method(DateTime::createFromFormat('Y-m-d\TH:i:sP', $data[$attribute]));
                    } 
                }
                
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    private function repairsTableAttribute(string $attribute) : string
    {
        if (preg_match('/ies$/', $attribute))
            return substr($attribute, 0, -3) . 'y';
        else if (preg_match('/s$/', $attribute))
            return substr($attribute, 0, -1);
        else
            return $attribute;
    }
    private function createRelation($id,string $attribute)
    {
        if (!is_array($id)){
            $entity = $this->em->getRepository('App\\Entity\\' . $attribute)->find($id);
            if (!$entity)
                throw new \Exception("Entity ".ucfirst($attribute)." (id: $id) not found");
            return $entity;    
        }
        else {
            $entities = [];
            foreach ($id as $value){
                $attribute = $this->repairsTableAttribute($attribute);
                $entities[] = $this->createRelation($value, $attribute);
            }
            return $entities;
        }
    }

    /**
     * variadic function
     * @param object $entity
     * @param string $acceptAttribute
     */
    protected function editEntity(object $entity , array $data, string ...$acceptAttribute) : object
    {
        foreach ($acceptAttribute as $attribute)
        {
            if (!isset($data[$attribute]))
                continue;
            $classEntityName = ucfirst(substr($attribute, 0, -2));
            if (preg_match('/Id$/', $attribute))
            {
                $relationnalEntity = $this->createRelation($data[$attribute], $classEntityName);
                if (is_array($data[$attribute]))
                {
                    $classEntityNameSingular = $this->repairsTableAttribute($classEntityName);
                    $method = 'get' . $classEntityName;
                    $entityCurrent = $entity->$method();
                    foreach ($entityCurrent as $value){
                        $method = 'remove' . $classEntityNameSingular;
                        $entity->$method($value);
                    }
                    foreach ($relationnalEntity as $value){
                        $method = 'add' . $classEntityNameSingular;
                        $entity->$method($value);
                    }
                }
                else
                { 
                    $method = 'set' . $classEntityName;
                    $entity->$method($relationnalEntity);
                }
            }
            else
            {
                $method = 'set' . ucfirst($attribute);
                try {
                    $entity->$method($data[$attribute]);
                } catch (TypeError $e) {
                    $entity->$method(DateTime::createFromFormat('Y-m-d\TH:i:sP', $data[$attribute]));
                }
            }
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
}
