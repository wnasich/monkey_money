<?php
namespace App\Model\Table;

use App\Model\Entity\Movement;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Movements Model
 *
 * @property \Cake\ORM\Association\BelongsTo $MovementTypes
 */
class MovementsTable extends Table
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

        $this->table('movements');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->belongsTo('MovementTypes', [
            'foreignKey' => 'movement_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreatedByUsers', [
            'className' => 'Users',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER'
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
            ->integer('movement_type_id')
            ->requirePresence('movement_type_id', 'create')
            ->notEmpty('movement_type_id', __('Please pick a movement type'), 'create');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount', __('Please enter an amount'), 'create');

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
        $rules->add($rules->existsIn(['movement_type_id'], 'MovementTypes'));
        $rules->add($rules->existsIn(['created_by'], 'CreatedByUsers'));
        return $rules;
    }

    public function findAllForClosing(Query $query, array $options)
    {
        $closing = $options['closing'];
        return $query
            ->where([
                'Movements.created >=' => $closing->since,
                'Movements.created <=' => $closing->created,
            ])
            ->contain(['MovementTypes'])
            ->orderAsc('Movements.created');
    }
}
