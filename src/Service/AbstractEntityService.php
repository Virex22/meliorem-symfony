<?php
namespace App\Service;

use App\Entity\Contact;
use App\Service\IService;
use Doctrine\ORM\EntityManagerInterface;


abstract class AbstractEntityService implements IService
{
    private $em;

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
                $relationnalEntity = $this->createRelation($data[$attribute]);
                if (is_array($data[$attribute]))
                    foreach ($relationnalEntity as $value){
                        $method = 'add' . ucfirst(substr($attribute, 0, -2));
                        $entity->$method($value);
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
                    if (!method_exists($entity, $method))
                        $method = 'is' . ucfirst($attribute);
                    $entity->$method($data[$attribute]);
                }
                
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    final private function createRelation($id)
    {
        if (!is_array($id)){
            $entity = $this->em->getRepository($this->getEntityClass())->find($id);
            if (!$entity)
                throw new \Exception('Entity not found');
            return $entity;    
        }
        else {
            foreach ($id as $value)
                yield $this->createRelation($value); // fonction recursive pour trouver chaque entité
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
            $methodEntityName = ucfirst(substr($attribute, 0, -2));
            if (preg_match('/Id$/', $attribute))
            {
                $relationnalEntity = $this->createRelation($data[$attribute]);
                if (is_array($data[$attribute]))
                {
                    $method = 'get' . $methodEntityName;
                    $entityCurrent = $entity->$method();
                    foreach ($entityCurrent as $value){
                        $method = 'remove' . $methodEntityName;
                        $entity->$method($value);
                    }
                    foreach ($relationnalEntity as $value){
                        $method = 'add' . $methodEntityName;
                        $entity->$method($value);
                    }
                }
                else
                { 
                    $method = 'set' . $methodEntityName;
                    $entity->$method($relationnalEntity);
                }
            }
            else
            {
                $method = 'set' . ucfirst($attribute);
                $entity->$method($data[$attribute]);
            }
        }
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
}
?>