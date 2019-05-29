<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeadEmailAttachments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LeadEmailMessages
 *
 * @method \App\Model\Entity\LeadEmailAttachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailAttachment findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadEmailAttachmentsTable extends Table
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

        $this->table('lead_email_attachments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LeadEmailMessages', [
            'foreignKey' => 'lead_email_message_id',
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
            ->requirePresence('attachment', 'create')
            ->notEmpty('attachment');

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
        $rules->add($rules->existsIn(['lead_email_message_id'], 'LeadEmailMessages'));

        return $rules;
    }
}
