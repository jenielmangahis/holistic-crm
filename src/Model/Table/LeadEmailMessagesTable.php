<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;

/**
 * LeadEmailMessages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Leads
 *
 * @method \App\Model\Entity\LeadEmailMessage get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeadEmailMessage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeadEmailMessage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailMessage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadEmailMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailMessage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeadEmailMessage findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadEmailMessagesTable extends Table
{

    const FOLDER_NAME = 'upload' . DS . 'lead_email_attachments' . DS;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('lead_email_messages');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Leads', [
            'foreignKey' => 'lead_id',
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
            ->requirePresence('subject', 'create')
            ->notEmpty('subject');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

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
        $rules->add($rules->existsIn(['lead_id'], 'Leads'));

        return $rules;
    }

    public function getAttachmentFolderLocation()
    {
        $path = WWW_ROOT . self::FOLDER_NAME; 
        return $path;
    }

    public function getFolderName()
    {
        return self::FOLDER_NAME;
    }

    public function uploadAttachment( $obj, $file, $is_completed = false ) 
    {
        //Store file
        $ext  = substr(strtolower(strrchr($file['name'], '.')), 1); 
        $new_file_name = $file['name'] . '_' . time() . '.' . $ext;

        //Create folder
        $locationPath   = self::getAttachmentFolderLocation() . $obj->id;        
        $dir = new Folder($locationPath, true, 0755);
        move_uploaded_file($file['tmp_name'], $locationPath . "/" . $new_file_name);
        return $new_file_name;
    }
}
