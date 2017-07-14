<?php
namespace App\Model\Table;

use App\Model\Entity\Closing;
use Cake\Core\Configure;
use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

use DateTime;

/**
 * Closings Model
 *
 */
class ClosingsTable extends Table
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

        $this->table('closings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->belongsTo('CreatedByUsers', [
            'className' => 'Users',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ModifiedByUsers', [
            'className' => 'Users',
            'foreignKey' => 'modified_by',
            'joinType' => 'INNER'
        ]);
    }

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema = parent::_initializeSchema($schema);
        $schema->columnType('change_bills', 'json');

        return $schema;
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
            ->decimal('closing_amount')
            ->allowEmpty('closing_amount');

        $validator
            ->decimal('change_amount')
            ->allowEmpty('change_amount');

        $validator
            ->allowEmpty('change_bills');

        $validator
            ->requirePresence('status', 'create')
            ->inList('status', array_keys(Closing::statusNames()))
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['modified_by'], 'ModifiedByUsers'));
        $rules->add($rules->existsIn(['created_by'], 'CreatedByUsers'));

        $rules->addCreate(function ($entity, $options) {
            return $entity->closing_amount || $entity->allow_empty_amount;
        }, 'isEmptyAllowed', [
            'errorField' => 'closing_amount',
            'message' => __('Please enter closing amount or check the option for ignore this message.'),
        ]);

        return $rules;
    }

    /**
     * Before save
     *
     * @param \Cake\Event\Event $event Event instance.
     * @param \Cake\Datasource\EntityInterface $entity Entity instance.
     * @throws \UnexpectedValueException if a field's when value is misdefined
     * @return true (irrespective of the behavior logic, the save will not be prevented)
     * @throws \UnexpectedValueException When the value for an event is not 'always', 'new' or 'existing'
     */
    public function beforeSave(Event $event, EntityInterface $entity)
    {
        if ($entity->isNew()) {
            // Asign new number
            $numberPrefix = Configure::read('Closing.numberPrefix');
            $day = date('d', strtotime('-5 hours'));

            do {
                $rand = str_pad(rand(0, 9), 1, '0', STR_PAD_LEFT);
                $number = $numberPrefix . $day . $rand;
            } while ($this->find('all', ['conditions' => [
                'number' => $number,
                'created >' => new DateTime('-3 day'),
            ]])->first());

            $entity->set('number', $number);

            // Gross input
            $grossInputAmount = 0;
            $lastClosing = $this->find('last');
            if ($lastClosing) {
                $since = $lastClosing->created;
                $entity->set('since', $since);

                $movementsTable = TableRegistry::get('Movements');
                $totalInput = 0;
                $totalOutput = 0;
                $movements = $movementsTable->find('allForClosing', ['closing' => $entity]);
                foreach ($movements as $movement) {
                    if ($movement->movement_type->output) {
                        $totalOutput += $movement->amount;
                    } else {
                        $totalInput += $movement->amount;
                    }
                }

                $grossInputAmount = $entity->closing_amount
                    - $totalInput
                    - $lastClosing->change_amount
                    + $entity->change_amount
                    + $totalOutput;
            }

            $entity->set('gross_input_amount', $grossInputAmount);
        }

        return true;
    }

    public function findLast(Query $query)
    {
        return $query
            ->where(['Closings.status <>' => Closing::STATUS_REMOVED])
            ->orderDesc('Closings.created')
            ->first();
    }

    public function previousTo(Closing $currentClosing)
    {
        $previousClosing = $this->query()
            ->where([
                'Closings.status <>' => Closing::STATUS_REMOVED,
                'Closings.id <' => $currentClosing->id,
            ])
            ->orderDesc('Closings.created')
            ->first();

        return $previousClosing;
    }

    public function billPackagesChanged(Closing $currentClosing)
    {
        $previousClosing = $this->previousTo($currentClosing);
        $billsChanged = [];
        if ($previousClosing) {
            $billsChanged = array_diff_assoc($previousClosing->change_bills, $currentClosing->change_bills);
        }

        $packagesChanged = [];
        foreach ($billsChanged as $billCode => $billCount) {
            if ($currentClosing->billCodeIsPackage($billCode)) {
                $packagesChanged[] = $billCode;
            }
        }

        return $packagesChanged;
    }

    public function outOfLevels(Closing $closing)
    {
        $billsDef = getBillsDefinitions();
        $bills = $billsDef['bills'] + $billsDef['packages'];

        $outOfLevels = [];
        foreach ($bills as $billCode => $billDef) {
            $billLevel = $closing->billLevel($billCode);
            if ($billLevel !== Closing::BILL_LEVEL_OK) {
                $outOfLevels[$billCode] = $billLevel;
            }
        }

        return $outOfLevels;
    }
}
