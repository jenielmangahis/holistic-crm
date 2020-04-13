<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sources Model
 *
 * @method \App\Model\Entity\Source get($primaryKey, $options = [])
 * @method \App\Model\Entity\Source newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Source[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Source|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Source patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Source[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Source findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SourcesTable extends Table
{

    const OPTIONS_IS_VA_YES = 1;
    const OPTIONS_IS_VA_NO  = 0;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('sources');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Allocations', [
            'foreignKey' => 'allocation_id',
            'joinType' => 'INNER'
        ]);     

        $this->hasMany('SourceUsers', [
            'foreignKey' => 'source_id'
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
            ->allowEmpty('emails');             

        return $validator;
    }

    public function optionsIsVa()
    {
        $options = [
            self::OPTIONS_IS_VA_NO => 'No',
            self::OPTIONS_IS_VA_YES => 'Yes'
        ];

        return $options;
    }

    public function isVa()
    {
        return self::OPTIONS_IS_VA_YES;
    }

    public function isNotVa()
    {
        return self::OPTIONS_IS_VA_NO;
    }

    public function sourceToCooling( $source_id = 0 )
    {
        $sources = [
            61 => 79, //CWC Las Vegas
            12 => 80, //CWC Los Angeles
            18 => 81, //CWC Miami
            58 => 82, //CWC Vancouver
            27 => 83, //CWC Florida
            9 => 78, //CWC Florida 
            59 => 84, //CWC Austin
            53 => 85, //CWC Denver
            51 => 86, //CWC Houston
            50 => 87, //CWC New Jersey
            56 => 77 //CWC WC Designers Group
        ];

        $new_source_id = $source_id;
        if( array_key_exists($source_id, $sources) ){
            $new_source_id = $sources[$source_id];
        }

        return $new_source_id;
    }
}
