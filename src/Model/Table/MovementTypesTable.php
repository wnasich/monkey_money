<?php
namespace App\Model\Table;

use App\Model\Entity\MovementType;
use App\Model\Rule\NoAssociatedData;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MovementTypes Model
 *
 * @property \Cake\ORM\Association\HasMany $Movements
 */
class MovementTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('movement_types');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Movements', [
            'foreignKey' => 'movement_type_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('output')
            ->allowEmpty('output');

        $validator
            ->integer('view_public')
            ->inList('view_public', array_keys(MovementType::viewPublicNames()))
            ->allowEmpty('view_public');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        foreach ($this->associations()->type('HasOne') + $this->associations()->type('HasMany') as $association) {
            $rules->addDelete(new NoAssociatedData($association));
        }
        return $rules;
    }
}
