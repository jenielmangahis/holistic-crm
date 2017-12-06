<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditTrailsFixture
 *
 */
class AuditTrailsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'action' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'utf16_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'event_status' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf16_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'details' => ['type' => 'integer', 'length' => 255, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'audit_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ip_address' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf16_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf16_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'action' => 'Lorem ipsum dolor sit amet',
            'event_status' => 'Lorem ipsum dolor ',
            'details' => 1,
            'audit_date' => '2017-12-06 00:23:24',
            'ip_address' => 'Lorem ipsum dolor sit amet',
            'created' => '2017-12-06 00:23:24',
            'modified' => '2017-12-06 00:23:24'
        ],
    ];
}
