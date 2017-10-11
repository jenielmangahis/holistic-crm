<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SourceUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SourceUsersTable Test Case
 */
class SourceUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SourceUsersTable
     */
    public $SourceUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.source_users',
        'app.sources',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.user_entities',
        'app.allocation_users',
        'app.allocations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SourceUsers') ? [] : ['className' => 'App\Model\Table\SourceUsersTable'];
        $this->SourceUsers = TableRegistry::get('SourceUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SourceUsers);

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
