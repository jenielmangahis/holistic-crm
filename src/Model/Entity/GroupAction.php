<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupAction Entity
 *
 * @property int $id
 * @property int $group_id
 * @property string $module
 * @property string $action
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Group $group
 */
class GroupAction extends Entity
{

}
