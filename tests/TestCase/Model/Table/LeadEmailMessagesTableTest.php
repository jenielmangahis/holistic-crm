<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadEmailMessagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadEmailMessagesTable Test Case
 */
class LeadEmailMessagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadEmailMessagesTable
     */
    public $LeadEmailMessages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lead_email_messages',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.user_entities',
        'app.allocation_users',
        'app.allocations',
        'app.source_users',
        'app.sources',
        'app.leads',
        'app.statuses',
        'app.lead_types',
        'app.interest_types',
        'app.last_modified_by',
        'app.lead_attachments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LeadEmailMessages') ? [] : ['className' => 'App\Model\Table\LeadEmailMessagesTable'];
        $this->LeadEmailMessages = TableRegistry::get('LeadEmailMessages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeadEmailMessages);

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
