<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Leads Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Statuses
 * @property \Cake\ORM\Association\BelongsTo $Sources
 * @property \Cake\ORM\Association\BelongsTo $Allocations
 * @property \Cake\ORM\Association\BelongsTo $InterestTypes
 *
 * @method \App\Model\Entity\Lead get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lead findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadsTable extends Table
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

        $this->table('leads');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sources', [
            'foreignKey' => 'source_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Allocations', [
            'foreignKey' => 'allocation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('InterestTypes', [
            'foreignKey' => 'interest_type_id',
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
            ->date('allocation_date')
            ->requirePresence('allocation_date', 'create')
            ->notEmpty('allocation_date');

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('surname', 'create')
            ->notEmpty('surname');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        /*$validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');*/

        /*$validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');*/

        /*$validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');*/

        /*$validator
            ->requirePresence('state', 'create')
            ->notEmpty('state');*/

        $validator
            ->date('followup_date')
            ->requirePresence('followup_date', 'create')
            ->notEmpty('followup_date');

        $validator
            ->date('followup_action_reminder_date')
            ->requirePresence('followup_action_reminder_date', 'create')
            ->notEmpty('followup_action_reminder_date');

        $validator
            ->allowEmpty('notes');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        $rules->add($rules->existsIn(['source_id'], 'Sources'));
        $rules->add($rules->existsIn(['allocation_id'], 'Allocations'));
        $rules->add($rules->existsIn(['interest_type_id'], 'InterestTypes'));

        return $rules;
    }
}
