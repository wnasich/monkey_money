<?php
namespace App\Model\Rule;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

class NoAssociatedData
{

    protected $association;

    public function __construct($association)
    {
        $this->association = $association;
    }

    public function __invoke(EntityInterface $entity, array $options)
    {
        $associatedRecords =
            TableRegistry::get($this->association->name())
                ->find()
                ->where([
                    $this->association->foreignKey() => $entity->{TableRegistry::get($entity->source())->primaryKey()}
                ])
                ->count()
        ;

        if ($associatedRecords > 0) {
            return false;
        }

        return true;
    }

}