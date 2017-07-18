<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AllocationUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AllocationUsersTable Test Case
 */
class AllocationUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AllocationUsersTable
     */
    public $AllocationUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.allocation_users',
        'app.allocations',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.user_entities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AllocationUsers') ? [] : ['className' => 'App\Model\Table\AllocationUsersTable'];
        $this->AllocationUsers = TableRegistry::get('AllocationUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AllocationUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
