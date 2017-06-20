<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lead Entity
 *
 * @property int $id
 * @property int $status_id
 * @property int $source_id
 * @property int $allocation_id
 * @property \Cake\I18n\Time $allocation_date
 * @property string $firstname
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property int $interest_type_id
 * @property \Cake\I18n\Time $followup_date
 * @property \Cake\I18n\Time $followup_action_reminder_date
 * @property string $notes
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Source $source
 * @property \App\Model\Entity\Allocation $allocation
 */
class Lead extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
