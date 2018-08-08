<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;

/**
 * LeadAttachments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Leads
 *
 * @method \App\Model\Entity\LeadAttachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\LeadAttachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LeadAttachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeadAttachment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LeadAttachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LeadAttachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeadAttachment findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeadAttachmentsTable extends Table
{
    const FOLDER_NAME = 'upload/leads_attachments/';

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('lead_attachments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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

    public function uploadAttachment( $obj, $file ) 
    {
        //Store photo
        $ext  = substr(strtolower(strrchr($file['name'], '.')), 1); 
        //$setNewFileName = 'attachment_' . time() . "_" . rand(000000, 999999) . $obj->id . '.' . $ext;
        $setNewFileName = $file['name'];
        $setNewFileName = str_replace(" ", "_", $setNewFileName);
        $setNewFileName = strtolower($setNewFileName);

        //Create folder
        $locationPath   = self::getAttachmentFolderLocation() . $obj->id;        
        $dir = new Folder($locationPath, true, 0755);
        move_uploaded_file($file['tmp_name'], $locationPath . "/" . $setNewFileName);
        return $setNewFileName;
    }
}
