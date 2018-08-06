<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeadAttachmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeadAttachmentsTable Test Case
 */
class LeadAttachmentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeadAttachmentsTable
     */
    public $LeadAttachments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lead_attachments',
        'app.leads',
        'app.statuses',
        'app.sources',
        'app.allocations',
        'app.source_users',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.groups',
        'app.user_entities',
        'app.allocation_users',
        'app.lead_types',
        'app.interest_types',
        'app.last_modified_by'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LeadAttachments') ? [] : ['className' => 'App\Model\Table\LeadAttachmentsTable'];
        $this->LeadAttachments = TableRegistry::get('LeadAttachments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeadAttachments);

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
