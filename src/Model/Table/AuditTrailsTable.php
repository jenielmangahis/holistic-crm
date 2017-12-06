<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuditTrails Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\AuditTrail get($primaryKey, $options = [])
 * @method \App\Model\Entity\AuditTrail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AuditTrail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AuditTrail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AuditTrail findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuditTrailsTable extends Table
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

        $this->table('audit_trails');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->requirePresence('action', 'create')
            ->notEmpty('action');

        $validator
            ->requirePresence('event_status', 'create')
            ->notEmpty('event_status');

        $validator
            ->integer('details')
            ->requirePresence('details', 'create')
            ->notEmpty('details');

        $validator
            ->dateTime('audit_date')
            ->allowEmpty('audit_date');

        $validator
            ->requirePresence('ip_address', 'create')
            ->notEmpty('ip_address');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
