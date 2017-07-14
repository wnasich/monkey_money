<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
    }

    protected function _initializeSchema(TableSchema $schema)
    {
        $schema = parent::_initializeSchema($schema);
        $schema->columnType('alerts', 'json');

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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->requirePresence('role', 'create')
            ->inList('role', array_keys(User::roleNames()))
            ->notEmpty('role');

        $validator
            ->email('email', false, __('Please enter a valid email address'))
            ->allowEmpty('email');

        $validator
            ->requirePresence('status', 'create')
            ->inList('status', array_keys(User::statusNames()))
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
        $rules->add($rules->isUnique(['username']));

        $rules->add(function ($entity, $options) {
            $valid = true;
            if ($entity->email) {
                $conditions = ['email' => $entity->email];
                if (!$entity->isNew()) {
                    $conditions['NOT'] = ['id' => $entity->id];
                }
                $valid = !$options['repository']->exists($conditions);
            }
            return $valid;
        }, 'isUniqueNotEmpty', [
            'errorField' => 'email',
            'message' => __('This email is already in use'),
        ]);

        $rules->addCreate(function ($entity, $options) {
            return $entity->isAdmin() || $entity->password;
        }, [
            'errorField' => 'password',
            'message' => __('Please enter a password')
        ]);

        return $rules;
    }


    public function findOperators(Query $query)
    {
        return $query
            ->where([
                'role' => User::ROLE_OPERATOR,
                'status' => User::STATUS_ENABLED,
            ])
            ->orderAsc('name');
    }

    public function findEmailsToAlert(Query $query, array $options)
    {
        $options += [
            'alertName' => null,
            'excludeUserId' => null,
        ];

        if (!in_array($options['alertName'], array_keys(User::alertNames()))) {
            throw new InvalidArgumentException('Invalid value for option alertName');
        }

        $users = $this->find('all', [
            'fields' => ['email', 'alerts'],
            'conditions' => [
                'Users.role' => User::ROLE_ADMIN,
                'Users.email IS NOT NULL',
                'Users.email <>' => '',
            ],
        ]);

        if ($options['excludeUserId']) {
            $users->andWhere(['Users.id <>' => $options['excludeUserId']]);
        }

        $recipients = [];
        foreach ($users as $user) {
            if ($user->alerts && in_array($options['alertName'], $user->alerts)) {
                $recipients[] = $user->email;
            }
        }

        return $recipients;
    }
}
